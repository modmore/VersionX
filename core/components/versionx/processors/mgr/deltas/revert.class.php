<?php

class VersionXObjectRevertProcessor extends modProcessor
{
    public \modmore\VersionX\VersionX $versionX;
    public \modmore\VersionX\Types\Type $type;
    protected int $deltaId;
    protected int $objectId;
    protected ?int $fieldId;

    public function initialize()
    {
        $init = parent::initialize();

        $this->versionX = new VersionX($this->modx);

        $typeClass = '\\' . $this->getProperty('type');
        $this->type = new $typeClass($this->modx, $this->versionX);

        $objectId = $this->getProperty('principal');
        if (empty($objectId)) {
            $this->modx->log(modX::LOG_LEVEL_ERROR, '[VersionX] Principal id not sent to revert processor!');
            return 'Principal object id not found.';
        }

        $deltaId = $this->getProperty('delta_id');
        if (empty($deltaId)) {
            $this->modx->log(modX::LOG_LEVEL_ERROR, '[VersionX] Delta id not sent to revert processor!');
            return 'Delta id not found.';
        }

        $this->objectId = $this->getProperty('principal');
        $this->deltaId = $this->getProperty('delta_id');
        $this->fieldId = $this->getProperty('field_id');

        return $init;
    }

    public function process()
    {
        switch ($this->getProperty('what')) {
            case 'revert_field':
                // Reverts a single field change on the object
                $this->versionX->deltas()->revertObject($this->deltaId, $this->objectId, $this->type, $this->fieldId);
                break;

            case 'revert_delta':
                // Reverts all field changes on the object that are related to the delta
                $this->versionX->deltas()->revertObject($this->deltaId, $this->objectId, $this->type);
                break;

            case 'revert_all':
                // Reverts all fields on the object to the end_time on the delta
                $this->versionX->deltas()->revertToPointInTime($this->deltaId, $this->objectId, $this->type);
                break;
        }

        return $this->success('Success');
    }
}
return 'VersionXObjectRevertProcessor';