<?php
require_once dirname(__DIR__) . '/revert.class.php';

class VersionXPluginsRevertProcessor extends VersionXRevertProcessor {
    public $classKey = 'vxPlugin';
}

return 'VersionXPluginsRevertProcessor';
