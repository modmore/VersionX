<?php

use modmore\VersionX\VersionX;

class VersionXOptimizeDeltasProcessor extends modProcessor
{
    public VersionX $versionX;

    /**
     * @return bool|string
     */
    public function initialize()
    {
        $init = parent::initialize();
        $this->versionX = new VersionX($this->modx);

        return $init;
    }

    public function process()
    {
        $this->versionX->deltas()->optimizeDeltas();
        return $this->success('Success');
    }
}
return 'VersionXOptimizeDeltasProcessor';