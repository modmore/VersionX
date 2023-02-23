<?php

namespace modmore\VersionX;

use Jfcherng\Diff\DiffHelper;
use modmore\VersionX\Types\Type;
use MODX\Revolution\modX;

class DeltaManager {
    /** @var \modX|modX */
    public $modx;

    function __construct($modx)
    {
        $this->modx = $modx;
    }

    /**
     * @param int $id
     * @param Type $type
     * @param string $mode
     * @return string|null
     */
    public function createDelta(int $id, Type $type, string $mode = 'update'): ?string
    {
        $now = time();
        // Get current principal object
        $object = $this->modx->getObject($type->getClass(), ['id' => $id]);
        $data = $object->toArray();

        // Get latest delta for this object
        $c = $this->modx->newQuery(\vxDelta::class);
        $c->setClassAlias('Delta');
        $c->where([
            'Delta.principal_package' => $type->getPackage(),
            'Delta.principal_class' => $type->getClass(),
            'Delta.principal' => $id,
        ]);
        $c->sortby('Delta.time_end', 'desc');
        $prevDelta = $this->modx->getObject(\vxDelta::class, $c);


        // Grab all the fields for the latest delta
        $prevFields = [];
        if ($prevDelta) {
            foreach ($this->modx->getCollection(\vxDeltaField::class, ['delta' => $prevDelta->get('id')]) as $item) {
                // Index array by field names
                $prevFields[$item->get('field')] = $item;
            }
        }

        $fieldsToSave = [];
        foreach ($data as $field => $value) {
            if (in_array($field, $type->getExcludedFields())) {
                continue;
            }

            $value = Utils::flattenArray($value);

            // If a previous delta exists, get the "after" value. Otherwise, use a blank string.
            $prevValue = '';
            if ($prevDelta instanceof \vxDelta && isset($prevFields[$field])) {
                $prevValue = $prevFields[$field]->get('after');
            }

            $diffOptions = [
                // show how many neighbor lines
                // Differ::CONTEXT_ALL can be used to show the whole file
                'context' => 3,
                // ignore case difference
                'ignoreCase' => false,
                // ignore whitespace difference
                'ignoreWhitespace' => false,
            ];
            $rendererOptions = [
                // how detailed the rendered HTML in-line diff is? (none, line, word, char)
                'detailLevel' => 'char',
                // show a separator between different diff hunks in HTML renderers
                'separateBlock' => true,
                // show the (table) header
                'showHeader' => false,
            ];

            // Do Diff
            $renderedDiff = DiffHelper::calculate(
                $prevValue,
                $value,
                'Inline',
                $diffOptions,
                $rendererOptions,
            );

            $deltaField = $this->modx->newObject('vxDeltaField', [
                'field' => $field,
                'field_type' => 'text',
                'before' => $prevValue,
                'after' => $value,
                'rendered_diff' => $renderedDiff,
            ]);

            $fieldsToSave[] = $deltaField;
        }

        // Check there's at least one field that was changed, otherwise there's no point saving them.
        $shouldSave = false;
        foreach ($fieldsToSave as $field) {
            if (!empty($field->get('rendered_diff'))) {
                $shouldSave = true;
            }
        }

        if (!$shouldSave) {
            return null;
        }

        /* @var \vxDelta $delta */
        $delta = $this->modx->newObject(\vxDelta::class, [
            'principal_package' => $type->getPackage(),
            'principal_class' => $type->getClass(),
            'principal' => $id,
            'time_start' => $now, // TODO: determine start and end time depending on the mode
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

//        $v = [
//            'content_id' => $data['id'],
//            'user' => $this->modx->user->get('id'),
//            'mode' => $mode,
//            'title' => $name,
//            'class' => $data['class_key'],
//            'content' => $object->get('content'),
//        ];
//
//        $version->fromArray($v);
//
//        unset ($data['id'],$data['content']);
//        $version->set('fields',$data);
//
//        $tvs = $object->getTemplateVars();
//        $tvArray = [];
//        /* @var \MODX\Revolution\modTemplateVar|\modTemplateVar $tv */
//        foreach ($tvs as $tv) {
//            $tvArray[] = $tv->get(['id', 'value']);
//        }
//        $version->set('tvs',$tvArray);
//
//        if($this->checkLastVersion('vxResource', $version)) {
//            return $version->save();
//        }
//        return true;

        return null;
    }
}