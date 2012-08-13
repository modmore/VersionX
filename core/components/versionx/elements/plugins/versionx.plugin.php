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

switch($eventName) {
    
    case 'OnBeforeDocFormSave':
         /**
         * ADDED - This is for workflow - allowing drafts
         */
        if ( $modx->getOption('versionx.workflow.resource',null,true) ){
            $result = $modx->versionx->resourceWorkflow($resource, $resource->get('version_publish'));
        }
        break;
    case 'OnDocFormSave':
        if ($modx->getOption('versionx.enable.resources',null,true)){
            $result = $modx->versionx->newResourceVersion($resource, $mode);
        }
        break;
    case 'OnTempFormSave':
        if ($modx->getOption('versionx.enable.templates',null,true))
            $result = $modx->versionx->newTemplateVersion($template, $mode);
        break;
    case 'OnTVFormSave':
        if ($modx->getOption('versionx.enable.templatevariables',null,true))
            $result = $modx->versionx->newTemplateVarVersion($tv, $mode);
        break;
    case 'OnChunkFormSave':
        if ($modx->getOption('versionx.enable.chunks',null,true) && is_object($chunk) ) {
            $result = $modx->versionx->newChunkVersion($chunk, $mode);
        }
        break;
    case 'OnSnipFormSave':
        if ($modx->getOption('versionx.enable.snippets',null,true))
            $result = $modx->versionx->newSnippetVersion($snippet, $mode);
        break;
    case 'OnPluginFormSave':
        if ($modx->getOption('versionx.enable.plugins',null,true))
            $result = $modx->versionx->newPluginVersion($plugin, $mode);
        break;
    
    case 'OnBeforeManagerPageInit':
    case 'OnManagerPageInit':
    case 'OnHandleRequest':

        break;

    /* Add tabs */
    case 'OnDocFormPrerender':
        $loadConfig = TRUE;
        if ($mode == modSystemEvent::MODE_UPD && $modx->getOption('versionx.formtabs.resource',null,true)) {
            $result = $modx->versionx->outputVersionsTab('vxResource');
            $loadConfig = FALSE; 
        }
        // Add work flow:
        if ( ($mode == modSystemEvent::MODE_NEW || $mode == modSystemEvent::MODE_UPD ) && $modx->getOption('versionx.workflow.resource',null,true)) {
            $url = NULL;
            if ($resource && $mode == modSystemEvent::MODE_UPD ) {
                $url = $modx->makeUrl($resource->get('id'),'',array('vxPreview'=>'latestDraft'), 'full');
            }
            $result = $modx->versionx->outputVersionsFields('vxResource', $url, $loadConfig); 
            if ( $mode == modSystemEvent::MODE_UPD ) {
                // set the current draft data for the resource:
                // $result = $modx->versionx->setCurrentWorkflowData($resource);
            }
        }
        break;
    case 'OnDocFormRender':
        if ( $mode == modSystemEvent::MODE_UPD && !isset($_REQUEST['reload']) ) {
            // set the current draft data for the resource:
            $result = $modx->versionx->setCurrentWorkflowData($resource);
        }
        break;
    case 'OnTempFormPrerender':
        if ($mode == modSystemEvent::MODE_UPD && $modx->getOption('versionx.formtabs.template',null,true)) {
            $result = $modx->versionx->outputVersionsTab('vxTemplate'); 
        }
        break;

    case 'OnTVFormPrerender':
        if ($mode == modSystemEvent::MODE_UPD && $modx->getOption('versionx.formtabs.templatevariable',null,true)) {
            $result = $modx->versionx->outputVersionsTab('vxTemplateVar');
        }
        break;


    case 'OnChunkFormPrerender':
        if ($mode == modSystemEvent::MODE_UPD && $modx->getOption('versionx.formtabs.chunk',null,true)) {
            $result = $modx->versionx->outputVersionsTab('vxChunk');
        }
        break;

    case 'OnSnipFormPrerender':
        if ($mode == modSystemEvent::MODE_UPD && $modx->getOption('versionx.formtabs.snippet',null,true)) {
            $result = $modx->versionx->outputVersionsTab('vxSnippet');
        }
        break;

    case 'OnPluginFormPrerender':
        if ($mode == modSystemEvent::MODE_UPD && $modx->getOption('versionx.formtabs.plugin',null,true)) {
            $result = $modx->versionx->outputVersionsTab('vxPlugin');
        }
        break;
    /* allow preview */
    case 'OnLoadWebDocument':
        /**
         * ADDED - This is for workflow/version previewing drafts or older versions
         */
        // @TODO: validate that user can see versions
        if ( isset($_GET['vxPreview']) && !empty($_GET['vxPreview']) ){
            if ( is_numeric($_GET['vxPreview']) ) {
                if ( $modx->versionx->isDebug() ) {
                    $modx->log(xPDO::LOG_LEVEL_ERROR, '[VersionX:vxResource] retreive specific draft data: '.$_GET['vxPreview']);
                }
                $previewVersion = $modx->versionx->getCurrentWorkflowVersion($modx->resource->get('id'), 'specific', $_GET['vxPreview']);
            } else { // if ( $_GET['vxPreview'] == 'latestDraft' ) {
                $previewVersion = $modx->versionx->getCurrentWorkflowVersion($modx->resource->get('id'), 'last');
            }
            if ( $previewVersion ) {
                $modx->resource = $previewVersion->retrieveData($modx->resource, 'last');
                if ( $modx->versionx->isDebug() ) {
                    $modx->log(xPDO::LOG_LEVEL_ERROR, '[VersionX:vxResource] retreive last draft data: '.
                        $previewVersion->get('version_id').' to preview - pagetitle: '.$modx->resource->get('pagetitle'));
                }
            }
        }
        
}
if (isset($result) && $result === true) {
    return;
} else if (isset($result)) {
    $modx->log(modX::LOG_LEVEL_ERROR,'[VersionX2] An error occured. Event: '.$eventName.' - Error: '.($result === false) ? 'undefined error' : $result);
    return;
}
