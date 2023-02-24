<?php
/**
 * VersionX
 *
 * @package versionx
 *
 * @var modX $modx
 * @var VersionX $versionX
 * @var int $id
 * @var string $mode
 * @var modResource $resource
 * @var modTemplate|\MODX\Revolution\modTemplate $template
 * @var modTemplateVar $tv
 * @var modChunk|\MODX\Revolution\modChunk $chunk
 * @var modSnippet|\MODX\Revolution\modSnippet $snippet
 * @var modPlugin|\MODX\Revolution\modPluginEvent $plugin
*/

use modmore\VersionX\Types\Resource;
use modmore\VersionX\Types\Template;
use modmore\VersionX\VersionX;

$eventName = $modx->event->name;

$path = $modx->getOption('versionx.core_path', null, MODX_CORE_PATH . 'components/versionx/');
require $path . 'vendor/autoload.php';

if (!$versionX = new VersionX($modx)) {
    $modx->log(modX::LOG_LEVEL_ERROR, 'Could not load VersionX');
    return;
}

switch($eventName) {
    case 'OnDocFormSave':
    case 'FredOnFredResourceSave':
        if ($modx->getOption('versionx.enable.resources',null,true) && $id) {
            $type = new Resource($modx, $versionX);
            $result = $versionX->deltas()->createDelta($id, $type, $mode);
        }
        break;

    case 'OnTempFormSave':
        if ($modx->getOption('versionx.enable.templates',null,true) && $id) {
            $type = new Template($modx, $versionX);
            $result = $versionX->deltas()->createDelta($id, $type, $mode);
        }
        break;

    case 'OnTVFormSave':
        if ($modx->getOption('versionx.enable.templatevariables',null,true))
            $result = $versionX->newTemplateVarVersion($tv, $mode);
        break;

    case 'OnChunkFormSave':
        if ($modx->getOption('versionx.enable.chunks',null,true))
            $result = $versionX->newChunkVersion($chunk, $mode);
        break;

    case 'OnSnipFormSave':
        if ($modx->getOption('versionx.enable.snippets',null,true))
            $result = $versionX->newSnippetVersion($snippet, $mode);
        break;

    case 'OnPluginFormSave':
        if ($modx->getOption('versionx.enable.plugins',null,true))
            $result = $versionX->newPluginVersion($plugin, $mode);
        break;

    case 'OnBeforeManagerPageInit': // Required for autoloading
    case 'OnManagerPageInit':
    case 'OnHandleRequest':

        break;

    /* Add tabs */
    case 'OnDocFormPrerender':
        if ($mode == modSystemEvent::MODE_UPD && $modx->getOption('versionx.formtabs.resource',null,true)) {
            $versionX->outputVersionsTab($id, new modmore\VersionX\Types\Resource($modx, $versionX));
        }
        break;

    case 'OnTempFormPrerender':
        if ($mode == modSystemEvent::MODE_UPD && $modx->getOption('versionx.formtabs.template',null,true)) {
            $versionX->outputVersionsTab($id, new modmore\VersionX\Types\Template($modx, $versionX));
        }
        break;

//    case 'OnTVFormPrerender':
//        if ($mode == modSystemEvent::MODE_UPD && $modx->getOption('versionx.formtabs.templatevariable',null,true)) {
//            $result = $versionX->outputVersionsTab('vxTemplateVar');
//        }
//        break;
//
//
//    case 'OnChunkFormPrerender':
//        if ($mode == modSystemEvent::MODE_UPD && $modx->getOption('versionx.formtabs.chunk',null,true)) {
//            $result = $versionX->outputVersionsTab('vxChunk');
//        }
//        break;
//
//    case 'OnSnipFormPrerender':
//        if ($mode == modSystemEvent::MODE_UPD && $modx->getOption('versionx.formtabs.snippet',null,true)) {
//            $result = $versionX->outputVersionsTab('vxSnippet');
//        }
//        break;
//
//    case 'OnPluginFormPrerender':
//        if ($mode == modSystemEvent::MODE_UPD && $modx->getOption('versionx.formtabs.plugin',null,true)) {
//            $result = $versionX->outputVersionsTab('vxPlugin');
//        }
//        break;

}
//if (isset($result) && $result === true)
//    return;
//elseif (isset($result)) {
//    $modx->log(modX::LOG_LEVEL_ERROR,'[VersionX2] An error occured. Event: '.$eventName.' - Error: '.($result === false) ? 'undefined error' : $result);
//    return;
//}

return true;