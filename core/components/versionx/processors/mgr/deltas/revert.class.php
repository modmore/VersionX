<?php

class VersionXObjectRevertProcessor extends modProcessor
{
    public \modmore\VersionX\VersionX $versionX;
    public \modmore\VersionX\Types\Type $type;
    protected int $objectId;
    protected int $deltaId;

    public function initialize(): bool
    {
        $init = parent::initialize();

        $this->versionX = new VersionX($this->modx);

        $typeClass = '\\' . $this->getProperty('type');
        $this->type = new $typeClass($this->modx, $this->versionX);

        $this->deltaId = $this->getProperty('id');
        $this->objectId = $this->getProperty('principal');

        return $init;
    }

    public function process()
    {
        $this->versionX->deltas()->revertObject($this->deltaId, $this->objectId, $this->type);

        return $this->success();
    }
}
return 'VersionXObjectRevertProcessor';