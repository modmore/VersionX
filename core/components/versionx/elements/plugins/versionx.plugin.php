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

use modmore\VersionX\Types\Chunk;
use modmore\VersionX\Types\Plugin;
use modmore\VersionX\Types\Snippet;
use modmore\VersionX\Types\TV;
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
            $type = new Resource($versionX);
            $result = $versionX->deltas()->createDelta($id, $type);
        }
        break;

    case 'OnTempFormSave':
        if ($modx->getOption('versionx.enable.templates',null,true) && $id) {
            $type = new Template($versionX);
            $result = $versionX->deltas()->createDelta($id, $type);
        }
        break;

    case 'OnTVFormSave':
        if ($modx->getOption('versionx.enable.templatevariables',null,true) && $id) {
            $type = new TV($versionX);
            $result = $versionX->deltas()->createDelta($id, $type);
        }
        break;

    case 'OnChunkFormSave':
        if ($modx->getOption('versionx.enable.chunks',null,true) && $id) {
            $type = new Chunk($versionX);
            $result = $versionX->deltas()->createDelta($id, $type);
        }
        break;

    case 'OnSnipFormSave':
        if ($modx->getOption('versionx.enable.snippets',null,true) && $id) {
            $type = new Snippet($versionX);
            $result = $versionX->deltas()->createDelta($id, $type);
        }
        break;

    case 'OnPluginFormSave':
        if ($modx->getOption('versionx.enable.plugins',null,true) && $id) {
            $type = new Plugin($versionX);
            $result = $versionX->deltas()->createDelta($id, $type);
        }
        break;

    case 'OnBeforeManagerPageInit': // Required for autoloading
    case 'OnManagerPageInit':
    case 'OnHandleRequest':

        break;

    /* Add tabs */
    case 'OnDocFormPrerender':
        if ($mode == modSystemEvent::MODE_UPD && $modx->getOption('versionx.formtabs.resource',null,true)) {
            $versionX->outputVersionsTab($id, new Resource($versionX));
        }
        break;

    case 'OnTempFormPrerender':
        if ($mode == modSystemEvent::MODE_UPD && $modx->getOption('versionx.formtabs.template',null,true)) {
            $versionX->outputVersionsTab($id, new Template($versionX));
        }
        break;

    case 'OnTVFormPrerender':
        if ($mode == modSystemEvent::MODE_UPD && $modx->getOption('versionx.formtabs.templatevariable',null,true)) {
            $versionX->outputVersionsTab($id, new TV($versionX));
        }
        break;

    case 'OnChunkFormPrerender':
        if ($mode == modSystemEvent::MODE_UPD && $modx->getOption('versionx.formtabs.chunk',null,true)) {
            $versionX->outputVersionsTab($id, new Chunk($versionX));
        }
        break;

    case 'OnSnipFormPrerender':
        if ($mode == modSystemEvent::MODE_UPD && $modx->getOption('versionx.formtabs.snippet',null,true)) {
            $versionX->outputVersionsTab($id, new Snippet($versionX));
        }
        break;

    case 'OnPluginFormPrerender':
        if ($mode == modSystemEvent::MODE_UPD && $modx->getOption('versionx.formtabs.plugin',null,true)) {
            $versionX->outputVersionsTab($id, new Plugin($versionX));
        }
        break;

}

return true;