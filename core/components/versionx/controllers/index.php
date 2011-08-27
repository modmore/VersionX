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
 */

require_once dirname(dirname(__FILE__)).'/model/versionx.class.php';
$versionx = new VersionX($modx);
$versionx->initialize('mgr');

$modx->regClientStartupHTMLBlock('
<script type="text/javascript">
    Ext.onReady(function() {
        VersionX.config = '.$modx->toJSON($versionx->config).';
    });
</script>');


$modx->regClientStartupScript($versionx->config['js_url'].'mgr/versionx.class.js');
$modx->regClientStartupScript($versionx->config['js_url'].'mgr/action.index.js');
/* Home */
$modx->regClientStartupScript($versionx->config['js_url'].'mgr/home/panel.home.js');
/* Resources */
$modx->regClientStartupScript($versionx->config['js_url'].'mgr/resources/panel.resources.js');
$modx->regClientStartupScript($versionx->config['js_url'].'mgr/resources/grid.resources.js');


return '<div id="versionx"></div>';

?>