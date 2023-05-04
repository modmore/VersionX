<?php

class VersionXDeltaMilestoneProcessor extends modProcessor
{
    public \modmore\VersionX\VersionX $versionX;
    protected int $deltaId;
    protected string $milestone = '';

    public function initialize()
    {
        $init = parent::initialize();

        $this->versionX = new VersionX($this->modx);

        $deltaId = $this->getProperty('delta_id');
        if (empty($deltaId)) {
            $this->modx->log(modX::LOG_LEVEL_ERROR, '[VersionX] Delta id not sent to milestone processor!');
            return 'Delta id not found.';
        }
        $this->deltaId = $this->getProperty('delta_id');

        if ($this->getProperty('what') === 'add') {
            $milestone = $this->getProperty('milestone');

            if (empty($milestone)) {
                $this->modx->log(modX::LOG_LEVEL_ERROR, '[VersionX] Milestone tag not sent to milestone processor!');
                return 'Milestone tag missing';
            }
            $this->milestone = $this->getProperty('milestone');
        }

        return $init;
    }

    public function process()
    {
        switch ($this->getProperty('what')) {
            case 'remove':
                // Remove milestone name from delta
                if ($this->versionX->deltas()->removeMilestone($this->deltaId)) {
                    return $this->success('Success');
                }

                break;

            case 'add':
                // Add milestone name to delta
                if ($this->versionX->deltas()->addMilestone($this->deltaId, $this->milestone)) {
                    return $this->success('Success');
                }
                break;
        }

        return $this->failure();
    }
}
return 'VersionXDeltaMilestoneProcessor';