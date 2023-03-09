<?php

namespace modmore\VersionX\Types;

use modmore\VersionX\Fields\Image;
use modmore\VersionX\Fields\Properties;
use modmore\VersionX\Fields\Text;

if (class_exists(\MODX\Revolution\modTemplateVarResource::class)) {
    class_alias(\MODX\Revolution\modTemplateVarResource::class, \modTemplateVarResource::class);
}

class Resource extends Type
{
    protected string $class = 'modResource';
    protected string $tabId = 'modx-resource-tabs';
    protected string $panelId = 'modx-panel-resource';
    protected string $package = 'core';
    protected string $nameField = 'pagetitle';
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
    protected array $fieldClassMap = [
        'properties' => Properties::class,
    ];
    protected array $tvTypes = [
        Image::class => [
            'image',
        ],
    ];

    public function includeFieldsOnCreate(array $fields, array $prevFields, \xPDOObject $object): array
    {
        // Determine what TV values currently exist for this resource.
        /** @var \modResource $object */
        $tvs = $object->getTemplateVars();
        $tvNames = [];
        foreach ($tvs as $tv) {
            $tvNames[] = $tv->get('name');
        }

        // Grab the most recent TV value fields
        $prevFields = $this->versionX->deltas()->getClosestDeltaFields($this, $object, $tvNames);

        // Loop through TVs matching previous delta fields by TV name
        /* @var \MODX\Revolution\modTemplateVar|\modTemplateVar $tv */
        foreach ($tvs as $tv) {
            $prevValue = '';
            foreach ($prevFields as $prevField) {
                if ($prevField->get('field') === $tv->get('name')) {
                    $prevValue = $prevField->get('after');
                    break;
                }
            }

            // Check if TV type is assigned to a VersionX field type
            $fieldObj = null;
            foreach ($this->tvTypes as $class => $types) {
                if (in_array($tv->get('type'), $types)) {
                    // If found, include the TV and resource id as config options to assist with rendering
                    $fieldObj = new $class($tv->get('value'), $tv->get('name'));
                }
            }

            // Default Text if no VersionX field types matched
            if (!isset($fieldObj)) {
                $fieldObj = new Text($tv->get('value'));
            }

            $field = $this->modx->newObject(\vxDeltaField::class, [
                'field' => $tv->get('name'),
                'field_type' => get_class($fieldObj),
                'before' => $prevValue,
                'after' => $tv->get('value'),
                'rendered_diff' => $fieldObj->render($prevValue, $fieldObj->getValue()),
            ]);

            $fields[] = $field;
        }

        return $fields;
    }

    public function afterRevert(array $fields, \xPDOObject $object, string $now, string $deltaTimestamp = null): \xPDOObject
    {
        // Be sure to call the parent method, so we get common field processing
        $object = parent::afterRevert($fields, $object, $deltaTimestamp, $now);

        $object->set('editedby', $this->modx->user->get('id'));
        $object->set('editedon', $now);

        // Get any TVs attached to this resource
        $tvs = $object->getMany('TemplateVars');

        $tvNames = [];
        foreach ($tvs as $tv) {
            $tvNames[] = $tv->get('name');
        }

        // Grab the most recent TV value fields
        $fields = array_merge(
            $fields,
            $this->versionX->deltas()->getClosestDeltaFields($this, $object, $tvNames, $deltaTimestamp)
        );

        foreach ($fields as $field) {
            $this->revertTVValues($field, $object, $tvs);
        }

        $object->save();

        return $object;
    }

    /**
     * Match field and TV names, updating TVs with delta field values.
     * @param \vxDeltaField $field
     * @param \xPDOObject $object
     * @param array $tvs
     * @return void
     */
    protected function revertTVValues(\vxDeltaField $field, \xPDOObject $object, array $tvs)
    {
        // TODO: consider recreating a TV if it has since been deleted... but may not be possible.
        foreach ($tvs as $tv) {
            if ($tv->get('name') === $field->get('field')) {
                // Get actual TV object to save, now that we have the id.
                $tvObj = $this->modx->getObject(\modTemplateVarResource::class, [
                    'tmplvarid' => $tv->get('id'),
                    'contentid' => $object->get('id'),
                ]);
                $this->modx->log(1, print_r($tvObj->toArray(), true));
                $tvObj->set('value', $field->get('before'));
                $tvObj->save();
            }
        }
    }
}