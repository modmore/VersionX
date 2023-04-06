<?php

class VersionXObjectFilterProcessor extends modObjectGetListProcessor
{
    public $classKey = vxDelta::class;
    public $defaultSortField = 'principal_class';
    public $defaultSortDirection = 'asc';
    public \modmore\VersionX\VersionX $versionX;

    /**
     * @return bool|string
     */
    public function initialize()
    {
        $init = parent::initialize();
        $this->versionX = new VersionX($this->modx);

        return $init;
    }

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
return 'VersionXObjectFilterProcessor';
