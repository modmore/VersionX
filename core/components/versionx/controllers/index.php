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

require_once dirname(dirname(__FILE__)).'/model/versionx.class.php';
$versionx = new VersionX($modx);
$versionx->initialize('mgr');

$versionid = (isset($_REQUEST['vid'])) ? (int)$_REQUEST['vid'] : false;
$compareid = (isset($_REQUEST['cmid'])) ? (int)$_REQUEST['cmid'] : false;
if (!isset($_REQUEST['action'])) $_REQUEST['action'] = 'index';
switch ($_REQUEST['action']) {
    case 'resource':
        /* If an ID was passed, fetch that version into a record array. */
        if ($versionid > 0) {
            $v = $versionx->getVersionDetails('vxResource',$versionid,true);
            if ($v !== false)
                $modx->regClientStartupHTMLBlock('<script type="text/javascript">VersionX.record = '.$v.'; </script>');
        }
        /* If an ID to compare to was passed, fetch that aswell. */
        if ($compareid > 0) {
            $v = $versionx->getVersionDetails('vxResource',$compareid,true);
            if ($v !== false)
                $modx->regClientStartupHTMLBlock('<script type="text/javascript">VersionX.cmrecord = '.$v.'; </script>');
        }

        $modx->regClientStartupScript($versionx->config['js_url'].'mgr/action.resource.js');
        $modx->regClientStartupScript($versionx->config['js_url'].'mgr/common/panel.common.js');
        $modx->regClientStartupScript($versionx->config['js_url'].'mgr/common/grid.common.js');
        $modx->regClientStartupScript($versionx->config['js_url'].'mgr/common/panel.content.js');
        $modx->regClientStartupScript($versionx->config['js_url'].'mgr/resources/detailpanel/panel.tvs.js');
        $modx->regClientStartupScript($versionx->config['js_url'].'mgr/resources/detailpanel.v21.resources.js');
        $modx->regClientStartupScript($versionx->config['js_url'].'mgr/resources/combo.versions.resources.js');        
    break;
    
    case 'template':
        /* If an ID was passed, fetch that version into a record array. */
        if ($versionid > 0) {
            $v = $versionx->getVersionDetails('vxTemplate',$versionid);
            if ($v !== false) {
                $modx->regClientStartupHTMLBlock('<script type="text/javascript">VersionX.record = '.$modx->toJSON($v).'; </script>');
            }
        }
        /* If an ID to compare to was passed, fetch that aswell. */
        if ($compareid > 0) {
            $v = $versionx->getVersionDetails('vxTemplate',$compareid);
            if ($v !== false) {
                $modx->regClientStartupHTMLBlock('<script type="text/javascript">VersionX.cmrecord = '.$modx->toJSON($v).'; </script>');
            }
        }

        $modx->regClientStartupScript($versionx->config['js_url'].'mgr/action.template.js');
        $modx->regClientStartupScript($versionx->config['js_url'].'mgr/common/panel.common.js');
        $modx->regClientStartupScript($versionx->config['js_url'].'mgr/common/grid.common.js');
        $modx->regClientStartupScript($versionx->config['js_url'].'mgr/common/panel.content.js');
        $modx->regClientStartupScript($versionx->config['js_url'].'mgr/templates/detailpanel.templates.js');
        $modx->regClientStartupScript($versionx->config['js_url'].'mgr/templates/combo.versions.templates.js'); 
    break;
    
    case 'templatevar':
        /* If an ID was passed, fetch that version into a record array. */
        if ($versionid > 0) {
            $v = $versionx->getVersionDetails('vxTemplateVar',$versionid);
            if ($v !== false) {
                $modx->regClientStartupHTMLBlock('<script type="text/javascript">VersionX.record = '.$modx->toJSON($v).'; </script>');
            }
        }
        /* If an ID to compare to was passed, fetch that aswell. */
        if ($compareid > 0) {
            $v = $versionx->getVersionDetails('vxTemplateVar',$compareid);
            if ($v !== false) {
                $modx->regClientStartupHTMLBlock('<script type="text/javascript">VersionX.cmrecord = '.$modx->toJSON($v).'; </script>');
            }
        }

        $modx->regClientStartupScript($versionx->config['js_url'].'mgr/action.templatevar.js');
        $modx->regClientStartupScript($versionx->config['js_url'].'mgr/common/panel.common.js');
        $modx->regClientStartupScript($versionx->config['js_url'].'mgr/common/grid.common.js');
        $modx->regClientStartupScript($versionx->config['js_url'].'mgr/templatevars/detailpanel.templatevars.js');
        $modx->regClientStartupScript($versionx->config['js_url'].'mgr/templatevars/combo.versions.templatevars.js'); 
    break;

    case 'chunk':
        /* If an ID was passed, fetch that version into a record array. */
        if ($versionid > 0) {
            $v = $versionx->getVersionDetails('vxChunk',$versionid);
            if ($v !== false) {
                $modx->regClientStartupHTMLBlock('<script type="text/javascript">VersionX.record = '.$modx->toJSON($v).'; </script>');
            }
        }
        /* If an ID to compare to was passed, fetch that aswell. */
        if ($compareid > 0) {
            $v = $versionx->getVersionDetails('vxChunk',$compareid);
            if ($v !== false) {
                $modx->regClientStartupHTMLBlock('<script type="text/javascript">VersionX.cmrecord = '.$modx->toJSON($v).'; </script>');
            }
        }

        $modx->regClientStartupScript($versionx->config['js_url'].'mgr/action.chunk.js');
        $modx->regClientStartupScript($versionx->config['js_url'].'mgr/common/panel.common.js');
        $modx->regClientStartupScript($versionx->config['js_url'].'mgr/common/grid.common.js');
        $modx->regClientStartupScript($versionx->config['js_url'].'mgr/common/panel.content.js');
        $modx->regClientStartupScript($versionx->config['js_url'].'mgr/chunks/detailpanel.chunks.js');
        $modx->regClientStartupScript($versionx->config['js_url'].'mgr/chunks/combo.versions.chunks.js');
    break;
    
    case 'index':
    default:
        /* Resources */
        $modx->regClientStartupScript($versionx->config['js_url'].'mgr/resources/panel.resources.js');
        $modx->regClientStartupScript($versionx->config['js_url'].'mgr/resources/grid.resources.js');
        /* Templates */
        $modx->regClientStartupScript($versionx->config['js_url'].'mgr/templates/panel.templates.js');
        $modx->regClientStartupScript($versionx->config['js_url'].'mgr/templates/grid.templates.js');
        /* Template Variables */
        $modx->regClientStartupScript($versionx->config['js_url'].'mgr/templatevars/panel.templatevars.js');
        $modx->regClientStartupScript($versionx->config['js_url'].'mgr/templatevars/grid.templatevars.js');
        /* Chunks */
        $modx->regClientStartupScript($versionx->config['js_url'].'mgr/chunks/panel.chunks.js');
        $modx->regClientStartupScript($versionx->config['js_url'].'mgr/chunks/grid.chunks.js');

        $modx->regClientStartupScript($versionx->config['js_url'].'mgr/action.index.js');
        break;
}


return '<div id="versionx"></div>';

?>
