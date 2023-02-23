<?php

namespace modmore\VersionX;

use Jfcherng\Diff\DiffHelper;
use modmore\VersionX\Types\Type;
use MODX\Revolution\modX;

class DeltaManager {
    /** @var \modX|modX */
    public $modx;
    protected array $diffOptions = [
        // show how many neighbor lines
        // Differ::CONTEXT_ALL can be used to show the whole file
        'context' => 3,
        // ignore case difference
        'ignoreCase' => false,
        // ignore whitespace difference
        'ignoreWhitespace' => false,
    ];
    protected array $rendererOptions = [
        // how detailed the rendered HTML in-line diff is? (none, line, word, char)
    'detailLevel' => 'char',
        // show a separator between different diff hunks in HTML renderers
    'separateBlock' => true,
        // show the (table) header
    'showHeader' => false,
    ];

    function __construct($modx)
    {
        $this->modx = $modx;
    }

    /**
     * @param int $objectId
     * @param Type $type
     * @return \vxDelta
     */
    public function getPreviousDelta(int $objectId, Type $type): \vxDelta
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
     * @param string $prevValue
     * @param string $value
     * @return string
     */
    public function calculateDiff(string $prevValue, string $value): string
    {
        return DiffHelper::calculate(
            $prevValue,
            $value,
            'Inline',
            $this->diffOptions,
            $this->rendererOptions,
        );
    }

    /**
     * @param int $id
     * @param Type $type
     * @param string $mode
     * @return \vxDelta|null
     */
    public function createDelta(int $id, Type $type, string $mode = 'update'): ?\vxDelta
    {
        $now = time();

        // Get current principal object
        $object = $this->modx->getObject($type->getClass(), ['id' => $id]);

        if (!$type->beforeDeltaCreate($now, $object)) {
            return null;
        }

        $data = $object->toArray();

        // Get latest delta for this object
        $prevDelta = $this->getPreviousDelta($id, $type);

        // Grab all the fields for the latest delta
        $prevFields = [];
        if ($prevDelta) {
            foreach ($this->modx->getCollection(\vxDeltaField::class, ['delta' => $prevDelta->get('id')]) as $item) {
                // Index array by field names
                $prevFields[$item->get('field')] = $item;
            }
        }

        $prevFields = $type->includePrevFieldsOnCreate($prevFields, $object);

        $fieldsToSave = [];
        foreach ($data as $field => $value) {
            if (in_array($field, $type->getExcludedFields())) {
                continue;
            }

            $value = Utils::toString($value);

            // If a previous delta exists, get the "after" value. Otherwise, use a blank string.
            $prevValue = '';
            if ($prevDelta instanceof \vxDelta && isset($prevFields[$field])) {
                $prevValue = $prevFields[$field]->get('after');
            }

            $deltaField = $this->modx->newObject('vxDeltaField', [
                'field' => $field,
                'field_type' => 'text',
                'before' => $prevValue,
                'after' => $value,
                'rendered_diff' => $this->calculateDiff($prevValue, $value),
            ]);

            $fieldsToSave[] = $deltaField;
        }

        // Give object types a way of adding additional fields to the delta
        $fieldsToSave = $type->includeNewFieldsOnCreate($fieldsToSave, $object);

        // Check there's at least one field that was changed, otherwise there's no point saving them.
        if (!$this->processFields($fieldsToSave)) {
            return null;
        }

        /* @var \vxDelta $delta */
        $delta = $this->modx->newObject(\vxDelta::class, [
            'principal_package' => $type->getPackage(),
            'principal_class' => $type->getClass(),
            'principal' => $id,
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
        }

        return $type->afterDeltaCreate($delta, $object);
    }

    /**
     * @param array $fieldsToSave
     * @return bool
     */
    protected function processFields(array $fieldsToSave): bool
    {
        $shouldSave = false;
        foreach ($fieldsToSave as $field) {
            if (!empty($field->get('rendered_diff'))) {
                $shouldSave = true;
            }
        }

        if (!$shouldSave) {
            return false;
        }

        return true;
    }
}