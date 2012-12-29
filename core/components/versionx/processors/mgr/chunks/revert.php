<?php

/* @var modX $modx
 * @var array $scriptProperties
 **/

$objectId = $modx->getOption('content_id',$scriptProperties, null);
$versionId = $modx->getOption('version_id',$scriptProperties, null);

if (!$objectId || !$versionId) {
    return $modx->error->failure('Resource or Version ID not specified.');
}

/* @var vxChunk $version */
$version = $modx->getObject('vxChunk',array(
    'content_id' => (int)$objectId,
    'version_id' => (int)$versionId
));

if (!($version instanceof vxChunk)) {
    return $modx->error->failure('Requested Version not found.');
}

if (!$version->revert()) {
    return $modx->error->failure('An error occured while reverting the version.');
} else {
    $modx->runProcessor('system/clearcache');
}

$modx->logManagerAction('vxchunk/revert','modChunk',$version->get('name') .  '(' . $version->get('content_id') . ' => ' . $versionId . ')');
$modx->versionx->newChunkVersion($objectId, 'revert');

return $modx->error->success();
