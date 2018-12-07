<?php
require_once dirname(__DIR__) . '/revert.class.php';

class VersionXChunksRevertProcessor extends VersionXRevertProcessor {
    public $classKey = 'vxChunk';
}

return 'VersionXChunksRevertProcessor';
