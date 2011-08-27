<?php


require_once dirname(dirname(__FILE__)) . '/config.core.php';
require_once MODX_CORE_PATH . 'model/modx/modx.class.php';
$modx= new modX();
$modx->initialize('mgr');
$modelPath = $modx->getOption('versionx.core_path',null,$modx->getOption('core_path').'components/versionx/').'model/';

$modx->addPackage('versionx',$modelPath);

$manager = $modx->getManager();
$modx->setLogLevel(modX::LOG_LEVEL_INFO);
$modx->setLogTarget('HTML');

$objects = array('vxResource','vxTemplate','vxSnippet','vxChunk','vxPlugin','vxTemplateVar');

foreach ($objects as $obj) {
    $manager->createObjectContainer($obj);
}
echo 'Done';
?>