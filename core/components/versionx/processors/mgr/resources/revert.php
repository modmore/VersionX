<?php

/* @var modX $modx
 * @var array $scriptProperties
 **/

$resourceId = $modx->getOption('content_id',$scriptProperties, null);
$versionId = $modx->getOption('version_id',$scriptProperties, null);

if (!$resourceId || !$versionId) {
    return $modx->error->failure('Resource or Version ID not specified.');
}

/* @var vxResource $version */
$version = $modx->getObject('vxResource',array(
    'content_id' => (int)$resourceId,
    'version_id' => (int)$versionId
));

if (!($version instanceof vxResource)) {
    return $modx->error->failure('Requested Version not found.');
}

if (!$version->revert()) {
    return $modx->error->failure('An error occured while reverting the version.');
} else {
    $modx->runProcessor('system/clearcache');
}

$modx->logManagerAction('vxresource/revert',$version->get('class'),$version->get('title') .  '(' . $version->get('content_id') . ' => ' . $versionId . ')');
$modx->versionx->newResourceVersion($resourceId, 'revert');

return $modx->error->success();
