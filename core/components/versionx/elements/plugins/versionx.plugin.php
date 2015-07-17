<?php
/**
 * VersionX
 *
 * Copyright 2011 by Mark Hamstra <hello@markhamstra.com>
 *
 * VersionX is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * VersionX is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * VersionX; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package versionx
 *
 * @var modX $modx
 * @var VersionX $versionx
 * @var int $id
 * @var string $mode
 * @var modResource $resource
 * @var modTemplate $template
 * @var modTemplateVar $tv
 * @var modChunk $chunk
 * @var modSnippet $snippet
 * @var modPlugin $plugin
*/

$eventName = $modx->event->name;

$path = $modx->getOption('versionx.core_path', null, MODX_CORE_PATH . 'components/versionx/');
$versionx = $modx->getService('versionx', 'VersionX', $path . 'model/');
if (!$versionx) {
    $modx->log(modX::LOG_LEVEL_ERROR, 'Could not load VersionX from ' . $path);
    return;
}

switch($eventName) {
    case 'OnDocFormSave':
        if ($modx->getOption('versionx.enable.resources',null,true))
            $result = $versionx->newResourceVersion($resource, $mode);
        break;
    case 'OnTempFormSave':
        if ($modx->getOption('versionx.enable.templates',null,true))
            $result = $versionx->newTemplateVersion($template, $mode);
        break;
    case 'OnTVFormSave':
        if ($modx->getOption('versionx.enable.templatevariables',null,true))
            $result = $versionx->newTemplateVarVersion($tv, $mode);
        break;
    case 'OnChunkFormSave':
        if ($modx->getOption('versionx.enable.chunks',null,true))
            $result = $versionx->newChunkVersion($chunk, $mode);
        break;
    case 'OnSnipFormSave':
        if ($modx->getOption('versionx.enable.snippets',null,true))
            $result = $versionx->newSnippetVersion($snippet, $mode);
        break;
    case 'OnPluginFormSave':
        if ($modx->getOption('versionx.enable.plugins',null,true))
            $result = $versionx->newPluginVersion($plugin, $mode);
        break;

    case 'OnBeforeManagerPageInit':
    case 'OnManagerPageInit':
    case 'OnHandleRequest':

        break;

    /* Add tabs */
    case 'OnDocFormPrerender':
        if ($mode == modSystemEvent::MODE_UPD && $modx->getOption('versionx.formtabs.resource',null,true)) {
            $result = $versionx->outputVersionsTab('vxResource');
        }
        break;

    case 'OnTempFormPrerender':
        if ($mode == modSystemEvent::MODE_UPD && $modx->getOption('versionx.formtabs.template',null,true)) {
            $result = $versionx->outputVersionsTab('vxTemplate');
        }
        break;

    case 'OnTVFormPrerender':
        if ($mode == modSystemEvent::MODE_UPD && $modx->getOption('versionx.formtabs.templatevariable',null,true)) {
            $result = $versionx->outputVersionsTab('vxTemplateVar');
        }
        break;


    case 'OnChunkFormPrerender':
        if ($mode == modSystemEvent::MODE_UPD && $modx->getOption('versionx.formtabs.chunk',null,true)) {
            $result = $versionx->outputVersionsTab('vxChunk');
        }
        break;

    case 'OnSnipFormPrerender':
        if ($mode == modSystemEvent::MODE_UPD && $modx->getOption('versionx.formtabs.snippet',null,true)) {
            $result = $versionx->outputVersionsTab('vxSnippet');
        }
        break;

    case 'OnPluginFormPrerender':
        if ($mode == modSystemEvent::MODE_UPD && $modx->getOption('versionx.formtabs.plugin',null,true)) {
            $result = $versionx->outputVersionsTab('vxPlugin');
        }
        break;

}
if (isset($result) && $result === true)
    return;
elseif (isset($result)) {
    $modx->log(modX::LOG_LEVEL_ERROR,'[VersionX2] An error occured. Event: '.$eventName.' - Error: '.($result === false) ? 'undefined error' : $result);
    return;
}
