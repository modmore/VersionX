<?php
$corePath = $modx->getOption('versionx.core_path',null,$modx->getOption('core_path').'components/versionx/');
require_once $corePath.'model/versionx.class.php';
$modx->versionx = new VersionX($modx);

include $corePath . 'elements/plugins/versionx.plugin.php';
return;