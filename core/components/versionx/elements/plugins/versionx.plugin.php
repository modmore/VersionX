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
        if ($modx->getOption('versionx.enable.templatevariables',null,true) && $id) {
            $type = new TV($modx, $versionX);
            $result = $versionX->deltas()->createDelta($id, $type, $mode);
        }
        break;

    case 'OnChunkFormSave':
        if ($modx->getOption('versionx.enable.chunks',null,true) && $id) {
            $type = new Chunk($modx, $versionX);
            $result = $versionX->deltas()->createDelta($id, $type, $mode);
        }
        break;

    case 'OnSnipFormSave':
        if ($modx->getOption('versionx.enable.snippets',null,true) && $id) {
            $type = new Snippet($modx, $versionX);
            $result = $versionX->deltas()->createDelta($id, $type, $mode);
        }
        break;

    case 'OnPluginFormSave':
        if ($modx->getOption('versionx.enable.plugins',null,true) && $id) {
            $type = new Plugin($modx, $versionX);
            $result = $versionX->deltas()->createDelta($id, $type, $mode);
        }
        break;

    case 'OnBeforeManagerPageInit': // Required for autoloading
    case 'OnManagerPageInit':
    case 'OnHandleRequest':

        break;

    /* Add tabs */
    case 'OnDocFormPrerender':
        if ($mode == modSystemEvent::MODE_UPD && $modx->getOption('versionx.formtabs.resource',null,true)) {
            $versionX->outputVersionsTab($id, new Resource($modx, $versionX));
        }
        break;

    case 'OnTempFormPrerender':
        if ($mode == modSystemEvent::MODE_UPD && $modx->getOption('versionx.formtabs.template',null,true)) {
            $versionX->outputVersionsTab($id, new Template($modx, $versionX));
        }
        break;

    case 'OnTVFormPrerender':
        if ($mode == modSystemEvent::MODE_UPD && $modx->getOption('versionx.formtabs.templatevariable',null,true)) {
            $versionX->outputVersionsTab($id, new TV($modx, $versionX));
        }
        break;

    case 'OnChunkFormPrerender':
        if ($mode == modSystemEvent::MODE_UPD && $modx->getOption('versionx.formtabs.chunk',null,true)) {
            $versionX->outputVersionsTab($id, new Chunk($modx, $versionX));
        }
        break;

    case 'OnSnipFormPrerender':
        if ($mode == modSystemEvent::MODE_UPD && $modx->getOption('versionx.formtabs.snippet',null,true)) {
            $versionX->outputVersionsTab($id, new Snippet($modx, $versionX));
        }
        break;

    case 'OnPluginFormPrerender':
        if ($mode == modSystemEvent::MODE_UPD && $modx->getOption('versionx.formtabs.plugin',null,true)) {
            $versionX->outputVersionsTab($id, new Plugin($modx, $versionX));
        }
        break;

}

return true;