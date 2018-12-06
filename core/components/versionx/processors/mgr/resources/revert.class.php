<?php
require_once dirname(__DIR__) . '/revert.class.php';

class VersionXResourceRevertProcessor extends VersionXRevertProcessor {
    public $classKey = 'vxResource';
}

return 'VersionXResourceRevertProcessor';