<?php

class VersionXPackagesFilterProcessor extends modObjectGetListProcessor
{
    public $classKey = vxDelta::class;
    public $defaultSortField = 'principal_package';
    public $defaultSortDirection = 'asc';

    /**
     * @param xPDOObject $object
     * @return array
     */
    public function prepareRow(xPDOObject $object): array
    {
        $name = $object->get('principal_package');
        return [
            'id' => $name,
            'name' => $name,
        ];
    }
}
return 'VersionXPackagesFilterProcessor';
