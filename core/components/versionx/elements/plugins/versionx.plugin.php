<?php
/**
 * VersionX
 *
 * Copyright 2011-2013 by Mark Hamstra <hello@markhamstra.com>
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
 * @var int $id
 * @var string $mode
 * @var modResource $resource
 * @var modTemplate $template
 * @var modTemplateVar $tv
 * @var modChunk $chunk
 * @var modSnippet $snippet
 * @var modPlugin $plugin
*/

$corePath = $modx->getOption('versionx.core_path',null,$modx->getOption('core_path').'components/versionx/');

$versionX = $modx->getService('versionx', 'VersionX' , $corePath . 'model/versionx/');
if (!($versionX instanceof VersionX)) {
    return 'Error loading VersionX class from ' . $corePath;
}

$eventName = $modx->event->name;

switch($eventName) {
    case 'OnDocFormSave':
        if ($modx->getOption('versionx.enable.resources',null,true))
            $result = $versionX->newResourceVersion($resource, $mode);
        break;
    case 'OnTempFormSave':
        if ($modx->getOption('versionx.enable.templates',null,true))
            $result = $versionX->newTemplateVersion($template, $mode);
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
    
    case 'OnBeforeManagerPageInit':
    case 'OnManagerPageInit':
    case 'OnHandleRequest':

        break;

    /* Add tabs */
    case 'OnDocFormPrerender':
        if ($mode == modSystemEvent::MODE_UPD && $modx->getOption('versionx.formtabs.resource',null,true)) {
            $versionX->outputVersionsTab('vxResource'); 
        }
        break;
    
    case 'OnTempFormPrerender':
        if ($mode == modSystemEvent::MODE_UPD && $modx->getOption('versionx.formtabs.template',null,true)) {
            $versionX->outputVersionsTab('vxTemplate'); 
        }
        break;

    case 'OnTVFormPrerender':
        if ($mode == modSystemEvent::MODE_UPD && $modx->getOption('versionx.formtabs.templatevariable',null,true)) {
            $versionX->outputVersionsTab('vxTemplateVar');
        }
        break;


    case 'OnChunkFormPrerender':
        if ($mode == modSystemEvent::MODE_UPD && $modx->getOption('versionx.formtabs.chunk',null,true)) {
            $versionX->outputVersionsTab('vxChunk');
        }
        break;

    case 'OnSnipFormPrerender':
        if ($mode == modSystemEvent::MODE_UPD && $modx->getOption('versionx.formtabs.snippet',null,true)) {
            $versionX->outputVersionsTab('vxSnippet');
        }
        break;

    case 'OnPluginFormPrerender':
        if ($mode == modSystemEvent::MODE_UPD && $modx->getOption('versionx.formtabs.plugin',null,true)) {
            $versionX->outputVersionsTab('vxPlugin');
        }
        break;

}
if (isset($result) && $result === true)
    return;
elseif (isset($result)) {
    $modx->log(modX::LOG_LEVEL_ERROR,'[VersionX2] An error occured. Event: '.$eventName.' - Error: '.($result === false) ? 'undefined error' : $result);
    return;
}
