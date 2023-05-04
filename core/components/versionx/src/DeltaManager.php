<?php

namespace modmore\VersionX;

use Carbon\Carbon;
use Jfcherng\Diff\DiffHelper;
use modmore\VersionX\Types\Type;
use modmore\VersionX\Enums\RevertAction;
use MODX\Revolution\modX;

class DeltaManager {
    public VersionX $versionX;
    /** @var \modX|modX */
    public $modx;
    protected static array $diffOptions = [
        // show how many neighbor lines
        // Differ::CONTEXT_ALL can be used to show the whole file
        'context' => 3,
        // ignore case difference
        'ignoreCase' => false,
        // ignore whitespace difference
        'ignoreWhitespace' => false,
    ];
    protected static array $rendererOptions = [
        // how detailed the rendered HTML in-line diff is? (none, line, word, char)
        'detailLevel' => 'char',
        // show a separator between different diff hunks in HTML renderers
        'separateBlock' => true,
        // show the (table) header
        'showHeader' => false,
    ];


    function __construct(VersionX $versionX)
    {
        $this->versionX = $versionX;
        $this->modx = $versionX->modx;
    }

    /**
     * @param string $prevValue
     * @param string $value
     * @return string
     */
    public static function calculateDiff(string $prevValue, string $value): string
    {
        return DiffHelper::calculate(
            $prevValue,
            $value,
            'Inline',
            self::$diffOptions,
            self::$rendererOptions,
        );
    }

    /**
     * @param int $objectId
     * @param Type $type
     * @return \vxDelta|null
     */
    public function getPreviousDelta(int $objectId, Type $type): ?\vxDelta
    {
        $c = $this->modx->newQuery(\vxDelta::class);
        $c->setClassAlias('Delta');
        $c->where([
            'Delta.principal_package' => $type->getPackage(),
            'Delta.principal_class' => $type->getClass(),
            'Delta.principal' => $objectId,
        ]);
        $c->sortby('Delta.time_end', 'desc');
        return $this->modx->getObject(\vxDelta::class, $c);
    }

    /**
     * @param int $id
     * @param Type $type
     * @return \vxDelta|null
     */
    public function createDelta(int $id, Type $type): ?\vxDelta
    {
        $now = Carbon::now()->toDateTimeString();

        // Get current principal object
        $object = $this->modx->getObject($type->getClass(), ['id' => $id]);

        if (!$type->beforeDeltaCreate($now, $object)) {
            return null;
        }

        $data = $type->getValues($object);

        // Get latest delta for this object
        $prevDelta = $this->getPreviousDelta($id, $type);

        // Grab all the fields for the latest delta
        $prevFields = [];
        if ($prevDelta) {
            foreach ($this->getClosestDeltaFields($type, $object) as $item) {
                // Index array by field names
                $prevFields[$item->get('field')] = $item;
            }
        }

        $fieldsToSave = [];
        foreach ($data as $field => $value) {
            if (in_array($field, $type->getExcludedFields())) {
                continue;
            }

            // Load the field type to access any extra rendering options
            $fieldType = $type->getFieldClass($field);
            $fieldTypeObj = new $fieldType($value);

            //
            $value = Utils::flattenArray($fieldTypeObj->getValue());

            // If a previous delta exists, get the "after" value. Otherwise, use a blank string.
            $prevValue = '';
            if ($prevDelta && isset($prevFields[$field])) {
                $prevValue = $prevFields[$field]->get('after');
            }

            try {
                $renderedDiff = $fieldTypeObj->render($prevValue, $value);
            }
            catch (\Error $e) {
                $this->modx->log(\modX::LOG_LEVEL_ERROR, '[VersionX] Fatal Error calculating diff: '
                    . "{$type->getClass()} id: {$id}\nField: {$field}\nField Type: $fieldType\n"
                    . $e->getMessage() . ' // ' . $e->getTraceAsString());
                return null;
            }

            $deltaField = $this->modx->newObject(\vxDeltaField::class, [
                'field' => $field,
                'field_type' => $fieldType,
                'before' => $prevValue,
                'after' => $value,
                'diff' => $renderedDiff, // Not persisted. Kept on object until cached.
            ]);

            $fieldsToSave[] = $deltaField;
        }

        // Give object types a way of adding additional fields to the delta
        $fieldsToSave = $type->includeFieldsOnCreate($fieldsToSave, $prevFields, $object);

        // Remove fields that haven't been changed
        $fieldsToSave = $this->processFields($fieldsToSave);
        if (empty($fieldsToSave)) {
            return null;
        }

        /* @var \vxDelta $delta */
        $delta = $this->modx->newObject(\vxDelta::class, [
            'principal_package' => $type->getPackage(),
            'principal_class' => $type->getClass(),
            'principal' => $id,
            'type_class' => get_class($type),
            'time_start' => $now,
            'time_end' => $now,
        ]);
        if (!$delta->save()) {
            $this->modx->log(MODX_LOG_LEVEL_ERROR, 'There was a problem saving the delta.');
            return null;
        }

        // Save the user details
        $deltaEditor = $this->modx->newObject(\vxDeltaEditor::class, [
            'delta' => $delta->get('id'),
            'user' => $this->modx->user->get('id'),
        ]);
        $deltaEditor->save();

        // Now that we have the foreign id, set it on the fields
        foreach ($fieldsToSave as $field) {
            $field->set('delta', $delta->get('id'));
            $field->save();

            // Save diffs to cache
            $key = "{$delta->get('principal_package')}"
                . "/{$delta->get('principal_class')}"
                . "/{$delta->get('principal')}"
                . "/{$delta->get('id')}"
                . "/{$field->get('id')}";

            $diff = $field->get('diff');
            $this->modx->cacheManager->set($key, $diff, 7200, VersionX::CACHE_OPT);
        }

        return $type->afterDeltaCreate($delta, $object);
    }

    /**
     * Reverts object to a delta (or singular field) state. A new delta is then created to represent the change.
     * @param int $deltaId
     * @param int $objectId
     * @param Type $type
     * @param null $fieldId
     * @return void
     */
    public function revertObject(int $deltaId, int $objectId, Type $type, $fieldId = null): void
    {
        $now = Carbon::now()->toDateTimeString();

        // Grab the object to revert
        $object = $this->modx->getObject($type->getClass(), [
            'id' => $objectId,
        ]);

        $fields = [];
        // If the $fieldId is set, get the singular field
        if ($fieldId) {
            $fields[] = $this->modx->getObject(\vxDeltaField::class, [
                'id' => $fieldId,
            ]);
            $action = RevertAction::SINGLE;
        }
        else {
            // Get all fields for this delta
            $fields = $this->modx->getCollection(\vxDeltaField::class, [
                'delta' => $deltaId,
            ]);
            $action = RevertAction::DELTA;
        }

        foreach ($fields as $field) {
            $object->set($field->get('field'), $field->get('before'));
        }

        // Now save the object
        if (!$object->save(true)) {
            $this->modx->log(MODX_LOG_LEVEL_ERROR,
                '[VersionX] Error saving ' . get_class($object) . ' with id: ' . $object->get('id'));
            return;
        }

        $object = $type->afterRevert($action, $fields, $object, $now, null);

        // Create new delta showing the reverted changes
        $delta = $this->createDelta($objectId, $type);
    }

    /**
     * Reverts all fields back to a point in time
     * @param int $deltaId
     * @param int $objectId
     * @param Type $type
     * @return void
     */
    public function revertToPointInTime(int $deltaId, int $objectId, Type $type)
    {
        $now = Carbon::now()->toDateTimeString();

        // Grab the object to revert
        $object = $this->modx->getObject($type->getClass(), [
            'id' => $objectId,
        ]);
        if (!$object) {
            $this->modx->log(MODX_LOG_LEVEL_ERROR,
                '[VersionX] Error loading ' . $type->getClass() . ' with id: ' . $objectId);
            return;
        }

        // Get the selected delta
        $delta = $this->modx->getObject(\vxDelta::class, [
            'id' => $deltaId,
        ]);

        // Get the delta timestamp
        $timestamp = $delta->get('time_start');

        // Get the first version of every field after the "time_end" on the selected delta
        $fields = [];
        foreach ($this->getClosestDeltaFields($type, $object, [], $timestamp) as $item) {
            $fields[$item->get('field')] = $item;
        }

        // Apply the field values to the object
        // We want to revert to all fields to the after value of a specific point in time.
        foreach ($fields as $field) {
            $object->set($field->get('field'), $field->get('before'));
        }

        // Now save the object
        if (!$object->save(true)) {
            $this->modx->log(MODX_LOG_LEVEL_ERROR,
                '[VersionX] Error saving ' . get_class($object) . ' with id: ' . $object->get('id'));
            return;
        }

        $object = $type->afterRevert(RevertAction::ALL, $fields, $object, $now, $timestamp);

        // Create new delta showing the reverted changes
        $delta = $this->createDelta($objectId, $type);
    }

    /**
     * @param array $fieldsToSave
     * @return array
     */
    protected function processFields(array $fieldsToSave): array
    {
        $shouldSave = false;
        foreach ($fieldsToSave as $k => $field) {
            // If there's at least one field that's changed then vxDelta should be persisted.
            if (!empty($field->get('diff'))) {
                $shouldSave = true;
            }
            // Remove any field that hasn't been changed.
            else {
                unset($fieldsToSave[$k]);
            }
        }

        if (!$shouldSave) {
            return [];
        }

        return $fieldsToSave;
    }

    /**
     * @param Type $type
     * @param \xPDOObject $object
     * @param array $fieldNames
     * @param string|null $timestamp
     * @return array
     */
    public function getClosestDeltaFields(Type $type, \xPDOObject $object, array $fieldNames = [], string $timestamp = null): array
    {
        $c = $this->modx->newQuery(\vxDeltaField::class);
        $c->innerJoin(\vxDelta::class, 'Delta', [
            'Delta.id = vxDeltaField.delta',
        ]);

        $data = $type->getValues($object);

        $objectFields = [];
        foreach ($data as $field => $value) {
            $objectFields[] = $field;
        }
        $where = [
            'Delta.principal' => $object->get('id'),
            'Delta.principal_class' => $type->getClass(),
            'Delta.principal_package' => $type->getPackage(),
        ];

        $excludedFields = $type->getExcludedFields();
        if (!empty($excludedFields)) {
            $where['vxDeltaField.field:NOT IN'] = $excludedFields;
        }

        if (!empty($fieldNames)) {
            $where['vxDeltaField.field:IN'] = $fieldNames;
        }
        else {
            $where['vxDeltaField.field:IN'] = $objectFields;
        }

        $select = [
            'field' => 'DISTINCT(vxDeltaField.field)',
        ];

        // If a timestamp is passed, get the fields directly after if they exist
        if ($timestamp) {
            $where['Delta.time_start:>'] = $timestamp;
            $select['time_end'] = 'MIN(Delta.time_end)';
            $select['id'] = 'MIN(vxDeltaField.id)';
        }
        // Without a timestamp, we just get the latest (closest to now)
        else {
            $select['time_end'] = 'MAX(Delta.time_end)';
            $select['id'] = 'MAX(vxDeltaField.id)';
        }

        $c->where($where);
        $c->select($select);
        $c->groupby('vxDeltaField.field');

//        $c->prepare();
//        $this->modx->log(1, $c->toSQL());

        return $this->modx->getCollection(\vxDeltaField::class, $c);
    }

    public function optimizeDeltas()
    {
        $deltaMerger = new DeltaMerger($this->versionX);
        $deltaMerger->run();
    }

    /**
     * @param int $deltaId
     * @param string $milestone
     * @return bool
     */
    public function addMilestone(int $deltaId, string $milestone): bool
    {
        $delta = $this->modx->getObject(\vxDelta::class, [
            'id' => $deltaId,
        ]);
        if ($delta) {
            $delta->set('milestone', $milestone);
            $delta->save();

            return true;
        }

        return false;
    }

    /**
     * @param int $deltaId
     * @return bool
     */
    public function removeMilestone(int $deltaId): bool
    {
        $delta = $this->modx->getObject(\vxDelta::class, [
            'id' => $deltaId,
        ]);
        if ($delta) {
            $delta->set('milestone', '');
            $delta->save();

            return true;
        }

        return false;
    }
}