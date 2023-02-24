<?php

namespace modmore\VersionX\Types;

class Resource extends Type
{
    protected string $class = 'modResource';
    protected string $tabId = 'modx-resource-tabs';
    protected string $package = 'core';
    protected string $nameField = 'pagetitle';
    protected array $tabJavaScript = [
        'common/grid.versions.js',
    ];
    protected array $excludedFields = [
        'createdon',
        'createdby',
        'editedon',
        'editedby',
    ];
    protected array $fieldOrder = [
        'pagetitle',
        'longtitle',
        'description',
        'introtext',
        'content',
        'alias',
    ];

    public function includeFieldsOnCreate(
        array $fields,
        array $prevFields,
        \vxDelta $prevDelta,
        \xPDOObject $object
    ): array
    {
        // Determine what TV values currently exist for this resource.
        /** @var \modResource $object */
        $tvs = $object->getTemplateVars();

        // Loop through TVs matching previous delta fields by TV name
        /* @var \MODX\Revolution\modTemplateVar|\modTemplateVar $tv */
        foreach ($tvs as $k => $tv) {
            $prevValue = '';
            foreach ($prevFields as $prevField) {
                if ($prevField->get('field') === $tv->get('name')) {
                    $prevValue = $prevField->get('after');
                    break;
                }
            }

            $field = $this->modx->newObject(\vxDeltaField::class, [
                'field' => $tv->get('name'),
                'field_type' => $tv->get('type'),
                'before' => $prevValue,
                'after' => $tv->get('value'),
                'rendered_diff' => $this->versionX->deltas()->calculateDiff($prevValue, $tv->get('value')),
            ]);

            $fields[] = $field;
        }

        return $fields;
    }

}