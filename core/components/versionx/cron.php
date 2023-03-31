<?php

use modmore\VersionX\VersionX;

require_once dirname(__DIR__, 3) . '/config.core.php';
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
require_once MODX_CONNECTORS_PATH . 'index.php';

$versionX = new VersionX($modx);
$versionX->deltas()->optimizeDeltas();

@session_write_close();
exit();