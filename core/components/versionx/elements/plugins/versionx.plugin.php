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
    case 'OnDocFormSave':
        $result = $modx->versionx->newResourceVersion($resource, $mode);
        break;
    case 'OnTempFormSave':
        $result = $modx->versionx->newTemplateVersion($template, $mode);
        break;
    case 'OnTVFormSave':
        $result = $modx->versionx->newTemplateVarVersion($tv, $mode);
        break;
    case 'OnChunkFormSave':
        $result = $modx->versionx->newChunkVersion($chunk, $mode);
        break;
    case 'OnSnipFormSave':
        $result = $modx->versionx->newSnippetVersion($snippet, $mode);
        break;
    case 'OnPluginFormSave':
        $result = $modx->versionx->newPluginVersion($plugin, $mode);
        break;
    
    case 'OnBeforeManagerPageInit':
    case 'OnManagerPageInit':
    case 'OnHandleRequest':

        break;

    /* Add tabs */
    case 'OnDocFormPrerender':
        if ($mode == 'upd') {
            $jsurl = $modx->getOption('versionx.assets_url',null,$modx->getOption('assets_url').'components/versionx/').'js/mgr/';
            
            $langs = '';
            $entries = $modx->lexicon->loadCache('versionx');
            foreach ($entries as $e => $v) {
                $v = htmlentities($v);
                $langs .= "MODx.lang['$e'] = \"$v\";";
            }
            
            /* Load class & set inVersion to true */
            $modx->regClientStartupScript($jsurl.'versionx.class.js');
            $modx->regClientStartupHTMLBlock('
                <script type="text/javascript">
                    VersionX.config = '.$modx->toJSON($modx->versionx->config).';
                    VersionX.inVersion = true;
                    '.$langs.'
                </script>');
            /* Load other JS */
            $modx->regClientStartupScript($jsurl.'resources/panel.resources.js');
            $modx->regClientStartupScript($jsurl.'resources/grid.resources.js');
            
            /* Create versions tab */
            $createtab = '<script type="text/javascript">
                Ext.onReady(function() {
                    MODx.addTab("modx-resource-tabs",{
                        title: \'Versions\',
                        id: \'versionx-resource-tab\',
                        layout: \'anchor\',
                        items: [{
                            xtype: \'versionx-panel-resources\',
                            layout: \'anchor\'
                        },{
                            xtype: \'versionx-grid-resources\',
                            width: \'95%\'
                        }]
                    });
                });
            </script>';
            $modx->regClientStartupHTMLBlock($createtab);
        }
        break;
}
if (isset($result) && $result === true)
    return;
elseif (isset($result)) {
    return $modx->log(1,'An error occured. Event: '.$eventName.' - Error: '.($result === false) ? 'false' : $result);
}
?>
