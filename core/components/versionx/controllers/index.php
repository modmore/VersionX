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
 * @var modX $modx
 * @var modAction $action
 */
$versionX = $modx->getService('versionx', 'VersionX' , dirname(dirname(__FILE__)) . '/model/versionx/');
if (!($versionX instanceof VersionX)) {
    return 'Error loading VersionX class from ' . dirname(dirname(__FILE__));
}
$versionX->initialize('mgr');

$scripts = array();
$scripts[] = $versionX->config['js_url'].'mgr/action.base.js';
$scripts[] = $versionX->config['js_url'].'mgr/widgets/combos.js';

$versionId = (isset($_REQUEST['vid'])) ? (int)$_REQUEST['vid'] : false;
$compareId = (isset($_REQUEST['cmid'])) ? (int)$_REQUEST['cmid'] : false;
if (!isset($_REQUEST['action'])) $_REQUEST['action'] = 'index';
switch ($_REQUEST['action']) {
    case 'resource':
        /* If an ID was passed, fetch that version into a record array. */
        if ($versionId > 0) {
            $v = $versionX->getVersionDetails('vxResource',$versionId,true);
            if ($v !== false)
                $modx->regClientStartupHTMLBlock('<script type="text/javascript">VersionX.record = '.$v.'; </script>');
        }
        /* If an ID to compare to was passed, fetch that aswell. */
        if ($compareId > 0) {
            $v = $versionX->getVersionDetails('vxResource',$compareId,true);
            if ($v !== false)
                $modx->regClientStartupHTMLBlock('<script type="text/javascript">VersionX.cmrecord = '.$v.'; </script>');
        }

        $scripts[] = $versionX->config['js_url'].'mgr/common/panel.common.js';
        $scripts[] = $versionX->config['js_url'].'mgr/common/grid.common.js';
        $scripts[] = $versionX->config['js_url'].'mgr/common/panel.content.js';
        $scripts[] = $versionX->config['js_url'].'mgr/resources/detailpanel/panel.tvs.js';
        $scripts[] = $versionX->config['js_url'].'mgr/resources/detailpanel.v21.resources.js';
        $modx->regClientStartupHTMLBlock("<script type=\"text/javascript\">
            Ext.applyIf(VersionX.panel, {ResourcesDetail:{}});
            Ext.applyIf(VersionX.grid, {ResourcesDetail:{}});
            Ext.onReady(function() { MODx.load({ xtype: 'versionx-page-base', type: 'resource' }); });
        </script>");
    break;
    
    case 'template':
        /* If an ID was passed, fetch that version into a record array. */
        if ($versionId > 0) {
            $v = $versionX->getVersionDetails('vxTemplate',$versionId);
            if ($v !== false) {
                $modx->regClientStartupHTMLBlock('<script type="text/javascript">VersionX.record = '.$modx->toJSON($v).'; </script>');
            }
        }
        /* If an ID to compare to was passed, fetch that aswell. */
        if ($compareId > 0) {
            $v = $versionX->getVersionDetails('vxTemplate',$compareId);
            if ($v !== false) {
                $modx->regClientStartupHTMLBlock('<script type="text/javascript">VersionX.cmrecord = '.$modx->toJSON($v).'; </script>');
            }
        }

        $scripts[] = $versionX->config['js_url'].'mgr/common/panel.common.js';
        $scripts[] = $versionX->config['js_url'].'mgr/common/grid.common.js';
        $scripts[] = $versionX->config['js_url'].'mgr/common/panel.content.js';
        $scripts[] = $versionX->config['js_url'].'mgr/templates/detailpanel.templates.js';
        $modx->regClientStartupHTMLBlock("<script type=\"text/javascript\">
            Ext.onReady(function() { MODx.load({ xtype: 'versionx-page-base', type: 'template' }); });
        </script>");
    break;
    
    case 'templatevar':
        /* If an ID was passed, fetch that version into a record array. */
        if ($versionId > 0) {
            $v = $versionX->getVersionDetails('vxTemplateVar',$versionId);
            if ($v !== false) {
                $modx->regClientStartupHTMLBlock('<script type="text/javascript">VersionX.record = '.$modx->toJSON($v).'; </script>');
            }
        }
        /* If an ID to compare to was passed, fetch that aswell. */
        if ($compareId > 0) {
            $v = $versionX->getVersionDetails('vxTemplateVar',$compareId);
            if ($v !== false) {
                $modx->regClientStartupHTMLBlock('<script type="text/javascript">VersionX.cmrecord = '.$modx->toJSON($v).'; </script>');
            }
        }

        $scripts[] = $versionX->config['js_url'].'mgr/common/panel.common.js';
        $scripts[] = $versionX->config['js_url'].'mgr/common/grid.common.js';
        $scripts[] = $versionX->config['js_url'].'mgr/templatevars/detailpanel.templatevars.js';
        $modx->regClientStartupHTMLBlock("<script type=\"text/javascript\">
            Ext.onReady(function() { MODx.load({ xtype: 'versionx-page-base', type: 'templatevar' }); });
        </script>");
    break;

    case 'chunk':
        /* If an ID was passed, fetch that version into a record array. */
        if ($versionId > 0) {
            $v = $versionX->getVersionDetails('vxChunk',$versionId);
            if ($v !== false) {
                $modx->regClientStartupHTMLBlock('<script type="text/javascript">VersionX.record = '.$modx->toJSON($v).'; </script>');
            }
        }
        /* If an ID to compare to was passed, fetch that aswell. */
        if ($compareId > 0) {
            $v = $versionX->getVersionDetails('vxChunk',$compareId);
            if ($v !== false) {
                $modx->regClientStartupHTMLBlock('<script type="text/javascript">VersionX.cmrecord = '.$modx->toJSON($v).'; </script>');
            }
        }

        $scripts[] = $versionX->config['js_url'].'mgr/common/panel.common.js';
        $scripts[] = $versionX->config['js_url'].'mgr/common/grid.common.js';
        $scripts[] = $versionX->config['js_url'].'mgr/common/panel.content.js';
        $scripts[] = $versionX->config['js_url'].'mgr/chunks/detailpanel.chunks.js';

        $modx->regClientStartupHTMLBlock("<script type=\"text/javascript\">
            Ext.onReady(function() { MODx.load({ xtype: 'versionx-page-base', type: 'chunk' }); });
        </script>");
    break;

    case 'snippet':
        /* If an ID was passed, fetch that version into a record array. */
        if ($versionId > 0) {
            $v = $versionX->getVersionDetails('vxSnippet',$versionId);
            if ($v !== false) {
                $modx->regClientStartupHTMLBlock('<script type="text/javascript">VersionX.record = '.$modx->toJSON($v).'; </script>');
            }
        }
        /* If an ID to compare to was passed, fetch that aswell. */
        if ($compareId > 0) {
            $v = $versionX->getVersionDetails('vxSnippet',$compareId);
            if ($v !== false) {
                $modx->regClientStartupHTMLBlock('<script type="text/javascript">VersionX.cmrecord = '.$modx->toJSON($v).'; </script>');
            }
        }

        $scripts[] = $versionX->config['js_url'].'mgr/common/panel.common.js';
        $scripts[] = $versionX->config['js_url'].'mgr/common/grid.common.js';
        $scripts[] = $versionX->config['js_url'].'mgr/common/panel.content.js';
        $scripts[] = $versionX->config['js_url'].'mgr/snippets/detailpanel.snippets.js';
        $modx->regClientStartupHTMLBlock("<script type=\"text/javascript\">
            Ext.onReady(function() { MODx.load({ xtype: 'versionx-page-base', type: 'snippet' }); });
        </script>");
    break;

    case 'plugin':
        /* If an ID was passed, fetch that version into a record array. */
        if ($versionId > 0) {
            $v = $versionX->getVersionDetails('vxPlugin',$versionId);
            if ($v !== false) {
                $modx->regClientStartupHTMLBlock('<script type="text/javascript">VersionX.record = '.$modx->toJSON($v).'; </script>');
            }
        }
        /* If an ID to compare to was passed, fetch that aswell. */
        if ($compareId > 0) {
            $v = $versionX->getVersionDetails('vxPlugin',$compareId);
            if ($v !== false) {
                $modx->regClientStartupHTMLBlock('<script type="text/javascript">VersionX.cmrecord = '.$modx->toJSON($v).'; </script>');
            }
        }

        $scripts[] = $versionX->config['js_url'].'mgr/common/panel.common.js';
        $scripts[] = $versionX->config['js_url'].'mgr/common/grid.common.js';
        $scripts[] = $versionX->config['js_url'].'mgr/common/panel.content.js';
        $scripts[] = $versionX->config['js_url'].'mgr/plugins/detailpanel.plugins.js';
        $modx->regClientStartupHTMLBlock("<script type=\"text/javascript\">
            Ext.onReady(function() { MODx.load({ xtype: 'versionx-page-base', type: 'plugin' }); });
        </script>");
    break;
    
    case 'index':
    default:
        $scripts[] = $versionX->config['js_url'].'mgr/resources/panel.resources.js';
        $scripts[] = $versionX->config['js_url'].'mgr/resources/grid.resources.js';
        $scripts[] = $versionX->config['js_url'].'mgr/templates/panel.templates.js';
        $scripts[] = $versionX->config['js_url'].'mgr/templates/grid.templates.js';
        $scripts[] = $versionX->config['js_url'].'mgr/templatevars/panel.templatevars.js';
        $scripts[] = $versionX->config['js_url'].'mgr/templatevars/grid.templatevars.js';
        $scripts[] = $versionX->config['js_url'].'mgr/chunks/panel.chunks.js';
        $scripts[] = $versionX->config['js_url'].'mgr/chunks/grid.chunks.js';
        $scripts[] = $versionX->config['js_url'].'mgr/snippets/panel.snippets.js';
        $scripts[] = $versionX->config['js_url'].'mgr/snippets/grid.snippets.js';
        $scripts[] = $versionX->config['js_url'].'mgr/plugins/panel.plugins.js';
        $scripts[] = $versionX->config['js_url'].'mgr/plugins/grid.plugins.js';
        $scripts[] = $versionX->config['js_url'].'mgr/action.index.js';
        break;
}

$scriptTags = '';
foreach ($scripts as $url) {
    $scriptTags .= '<script type="text/javascript" src="'.$url.'?vxv='.urlencode($versionX->config['version']).'"></script>';
}
$modx->regClientStartupHTMLBlock($scriptTags);

return '<div id="versionx"></div>';

