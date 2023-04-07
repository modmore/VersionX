<?php

class VersionXClassFilterProcessor extends modObjectGetListProcessor
{
    public $classKey = vxDelta::class;
    public $defaultSortField = 'principal_class';
    public $defaultSortDirection = 'asc';

    /**
     * @param xPDOObject $object
     * @return array
     */
    public function prepareRow(xPDOObject $object): array
    {
        $name = $object->get('principal_class');
        return [
            'id' => $name,
            'name' => $name,
        ];
    }
}
return 'VersionXClassFilterProcessor';
