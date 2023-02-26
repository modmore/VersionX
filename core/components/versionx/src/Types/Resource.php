<?php

namespace modmore\VersionX\Types;

if (!class_exists(\modTemplateVarResource::class)) {
    class_alias('\MODX\Revolution\modTemplateVarResource', '\modTemplateVarResource');
}

class Resource extends Type
{
    protected string $class = 'modResource';
    protected string $tabId = 'modx-resource-tabs';
    protected string $package = 'core';
    protected string $nameField = 'pagetitle';
    protected string $mgrAction = 'resource/update';
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
        $prevFields = $this->versionX->deltas()->getLatestFieldVersions($this, $object, $tvNames);

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

    public function afterRevert(array $fields, \xPDOObject $object, int $timestamp): \xPDOObject
    {
        $object->set('editedby', $this->modx->user->get('id'));
        $object->set('editedon', $timestamp);

        // Get any TVs attached to this resource
        $tvs = $object->getMany('TemplateVars');

        // Match field and TV names, updating TVs with delta field values.
        foreach ($fields as $field) {
            foreach ($tvs as $tv) {
                if ($tv->get('name') === $field->get('field')) {
                    // Get actual TV object to save, now that we have the id.
                    $tvObj = $this->modx->getObject(\modTemplateVarResource::class, [
                        'tmplvarid' => $tv->get('id'),
                    ]);
                    $tvObj->set('value', $field->get('before'));
                    $tvObj->save();
                }
            }
        }

        // TODO: consider recreating a TV if it has since been deleted... but may not be possible.

        return $object;
    }
}