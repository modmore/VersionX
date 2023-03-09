<?php

class VersionXObjectRevertProcessor extends modProcessor
{
    public \modmore\VersionX\VersionX $versionX;
    public \modmore\VersionX\Types\Type $type;
    protected int $deltaId;
    protected int $objectId;
    protected int $fieldId;

    public function initialize(): bool
    {
        $init = parent::initialize();

        $this->versionX = new VersionX($this->modx);

        $typeClass = '\\' . $this->getProperty('type');
        $this->type = new $typeClass($this->modx, $this->versionX);

        $this->objectId = $this->getProperty('principal');
        $this->deltaId = $this->getProperty('delta_id');
        $this->fieldId = $this->getProperty('field_id');

        return $init;
    }

    public function process()
    {
        switch ($this->getProperty('what')) {
            // Reverts a single field change on the object
            case 'revert_field':
                $this->versionX->deltas()->revertObject($this->deltaId, $this->objectId, $this->type, $this->fieldId);
                break;
            // Reverts all field changes on the object that are related to the delta
            case 'revert_delta':
                $this->versionX->deltas()->revertObject($this->deltaId, $this->objectId, $this->type);
                break;
            // Reverts all fields on the object to the end_time on the delta
            case 'revert_all':
                $this->versionX->deltas()->timeTravel($this->deltaId, $this->objectId, $this->type);
                break;
        }

        return $this->success('Success');
    }
}
return 'VersionXObjectRevertProcessor';