<?php

/* @var modX $modx
 * @var array $scriptProperties
 **/

$objectId = $modx->getOption('content_id',$scriptProperties, null);
$versionId = $modx->getOption('version_id',$scriptProperties, null);

if (!$objectId || !$versionId) {
    return $modx->error->failure('Object or Version ID not specified.');
}

/* @var vxSnippet $version */
$version = $modx->getObject('vxSnippet',array(
    'content_id' => (int)$objectId,
    'version_id' => (int)$versionId
));

if (!($version instanceof vxSnippet)) {
    return $modx->error->failure('Requested Version not found.');
}

if (!$version->revert()) {
    return $modx->error->failure('An error occured while reverting the version.');
} else {
    $modx->runProcessor('system/clearcache');
}

$modx->logManagerAction('vxSnippet/revert','modSnippet',$version->get('name') .  '(' . $version->get('content_id') . ' => ' . $versionId . ')');
$modx->versionx->newSnippetVersion($objectId, 'revert');

return $modx->error->success();
