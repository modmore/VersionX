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

require_once __DIR__ . '/base.class.php';

class VersionXIndexManagerController extends VersionXBaseManagerController {

    public function loadCustomCssJs()
    {
        $cachebust = '?vxv=' . urlencode($this->versionx->config['version']);
        $scripts = array();

        $versionid = isset($_REQUEST['vid']) ? (int)$_REQUEST['vid'] : false;
        $compareid = isset($_REQUEST['cmid']) ? (int)$_REQUEST['cmid'] : false;
        if (!isset($_REQUEST['action'])) {
            $_REQUEST['action'] = 'index';
        }

        switch ($_REQUEST['action']) {
            case 'resource':
                /* If an ID was passed, fetch that version into a record array. */
                if ($versionid > 0) {
                    $v = $this->versionx->getVersionDetails('vxResource', $versionid, true);
                    if ($v !== false) {
                        $this->addHtml('<script type="text/javascript">VersionX.record = ' . $v . '; </script>');
                    }
                }
                /* If an ID to compare to was passed, fetch that aswell. */
                if ($compareid > 0) {
                    $v = $this->versionx->getVersionDetails('vxResource', $compareid, true);
                    if ($v !== false) {
                        $this->addHtml('<script type="text/javascript">VersionX.cmrecord = ' . $v . '; </script>');
                    }
                }

                $scripts[] = $this->versionx->config['js_url'] . 'mgr/common/panel.common.js';
                $scripts[] = $this->versionx->config['js_url'] . 'mgr/common/grid.common.js';
                $scripts[] = $this->versionx->config['js_url'] . 'mgr/common/panel.content.js';
                $scripts[] = $this->versionx->config['js_url'] . 'mgr/resources/detailpanel/panel.tvs.js';
                $scripts[] = $this->versionx->config['js_url'] . 'mgr/resources/detailpanel.v21.resources.js';
                $scripts[] = $this->versionx->config['js_url'] . 'mgr/resources/combo.versions.resources.js';
                $this->addLastJavascript($this->versionx->config['js_url'] . 'mgr/action.resource.js' . $cachebust);
                break;

            case 'template':
                /* If an ID was passed, fetch that version into a record array. */
                if ($versionid > 0) {
                    $v = $this->versionx->getVersionDetails('vxTemplate', $versionid);
                    if ($v !== false) {
                        $this->addHtml('<script type="text/javascript">VersionX.record = ' . $this->modx->toJSON($v) . '; </script>');
                    }
                }
                /* If an ID to compare to was passed, fetch that aswell. */
                if ($compareid > 0) {
                    $v = $this->versionx->getVersionDetails('vxTemplate', $compareid);
                    if ($v !== false) {
                        $this->addHtml('<script type="text/javascript">VersionX.cmrecord = ' . $this->modx->toJSON($v) . '; </script>');
                    }
                }

                $scripts[] = $this->versionx->config['js_url'] . 'mgr/common/panel.common.js';
                $scripts[] = $this->versionx->config['js_url'] . 'mgr/common/grid.common.js';
                $scripts[] = $this->versionx->config['js_url'] . 'mgr/common/panel.content.js';
                $scripts[] = $this->versionx->config['js_url'] . 'mgr/templates/detailpanel.templates.js';
                $scripts[] = $this->versionx->config['js_url'] . 'mgr/templates/combo.versions.templates.js';
                $this->addLastJavascript($this->versionx->config['js_url'] . 'mgr/action.template.js' . $cachebust);
                break;

            case 'templatevar':
                /* If an ID was passed, fetch that version into a record array. */
                if ($versionid > 0) {
                    $v = $this->versionx->getVersionDetails('vxTemplateVar', $versionid);
                    if ($v !== false) {
                        $this->addHtml('<script type="text/javascript">VersionX.record = ' . $this->modx->toJSON($v) . '; </script>');
                    }
                }
                /* If an ID to compare to was passed, fetch that aswell. */
                if ($compareid > 0) {
                    $v = $this->versionx->getVersionDetails('vxTemplateVar', $compareid);
                    if ($v !== false) {
                        $this->addHtml('<script type="text/javascript">VersionX.cmrecord = ' . $this->modx->toJSON($v) . '; </script>');
                    }
                }

                $scripts[] = $this->versionx->config['js_url'] . 'mgr/common/panel.common.js';
                $scripts[] = $this->versionx->config['js_url'] . 'mgr/common/grid.common.js';
                $scripts[] = $this->versionx->config['js_url'] . 'mgr/templatevars/detailpanel.templatevars.js';
                $scripts[] = $this->versionx->config['js_url'] . 'mgr/templatevars/combo.versions.templatevars.js';
                $this->addLastJavascript($this->versionx->config['js_url'] . 'mgr/action.templatevar.js' . $cachebust);
                break;

            case 'chunk':
                /* If an ID was passed, fetch that version into a record array. */
                if ($versionid > 0) {
                    $v = $this->versionx->getVersionDetails('vxChunk', $versionid);
                    if ($v !== false) {
                        $this->addHtml('<script type="text/javascript">VersionX.record = ' . $this->modx->toJSON($v) . '; </script>');
                    }
                }
                /* If an ID to compare to was passed, fetch that aswell. */
                if ($compareid > 0) {
                    $v = $this->versionx->getVersionDetails('vxChunk', $compareid);
                    if ($v !== false) {
                        $this->addHtml('<script type="text/javascript">VersionX.cmrecord = ' . $this->modx->toJSON($v) . '; </script>');
                    }
                }

                $scripts[] = $this->versionx->config['js_url'] . 'mgr/common/panel.common.js';
                $scripts[] = $this->versionx->config['js_url'] . 'mgr/common/grid.common.js';
                $scripts[] = $this->versionx->config['js_url'] . 'mgr/common/panel.content.js';
                $scripts[] = $this->versionx->config['js_url'] . 'mgr/chunks/detailpanel.chunks.js';
                $scripts[] = $this->versionx->config['js_url'] . 'mgr/chunks/combo.versions.chunks.js';
                $this->addLastJavascript($this->versionx->config['js_url'] . 'mgr/action.chunk.js' . $cachebust);
                break;

            case 'snippet':
                /* If an ID was passed, fetch that version into a record array. */
                if ($versionid > 0) {
                    $v = $this->versionx->getVersionDetails('vxSnippet', $versionid);
                    if ($v !== false) {
                        $this->addHtml('<script type="text/javascript">VersionX.record = ' . $this->modx->toJSON($v) . '; </script>');
                    }
                }
                /* If an ID to compare to was passed, fetch that aswell. */
                if ($compareid > 0) {
                    $v = $this->versionx->getVersionDetails('vxSnippet', $compareid);
                    if ($v !== false) {
                        $this->addHtml('<script type="text/javascript">VersionX.cmrecord = ' . $this->modx->toJSON($v) . '; </script>');
                    }
                }

                $scripts[] = $this->versionx->config['js_url'] . 'mgr/common/panel.common.js';
                $scripts[] = $this->versionx->config['js_url'] . 'mgr/common/grid.common.js';
                $scripts[] = $this->versionx->config['js_url'] . 'mgr/common/panel.content.js';
                $scripts[] = $this->versionx->config['js_url'] . 'mgr/snippets/detailpanel.snippets.js';
                $scripts[] = $this->versionx->config['js_url'] . 'mgr/snippets/combo.versions.snippets.js';
                $this->addLastJavascript($this->versionx->config['js_url'] . 'mgr/action.snippet.js' . $cachebust);
                break;

            case 'plugin':
                /* If an ID was passed, fetch that version into a record array. */
                if ($versionid > 0) {
                    $v = $this->versionx->getVersionDetails('vxPlugin', $versionid);
                    if ($v !== false) {
                        $this->addHtml('<script type="text/javascript">VersionX.record = ' . $this->modx->toJSON($v) . '; </script>');
                    }
                }
                /* If an ID to compare to was passed, fetch that aswell. */
                if ($compareid > 0) {
                    $v = $this->versionx->getVersionDetails('vxPlugin', $compareid);
                    if ($v !== false) {
                        $this->addHtml('<script type="text/javascript">VersionX.cmrecord = ' . $this->modx->toJSON($v) . '; </script>');
                    }
                }

                $scripts[] = $this->versionx->config['js_url'] . 'mgr/common/panel.common.js';
                $scripts[] = $this->versionx->config['js_url'] . 'mgr/common/grid.common.js';
                $scripts[] = $this->versionx->config['js_url'] . 'mgr/common/panel.content.js';
                $scripts[] = $this->versionx->config['js_url'] . 'mgr/plugins/detailpanel.plugins.js';
                $scripts[] = $this->versionx->config['js_url'] . 'mgr/plugins/combo.versions.plugins.js';
                $this->addLastJavascript($this->versionx->config['js_url'] . 'mgr/action.plugin.js' . $cachebust);
                break;

            case 'index':
            default:
                $scripts[] = $this->versionx->config['js_url'] . 'mgr/resources/panel.resources.js';
                $scripts[] = $this->versionx->config['js_url'] . 'mgr/resources/grid.resources.js';
                $scripts[] = $this->versionx->config['js_url'] . 'mgr/templates/panel.templates.js';
                $scripts[] = $this->versionx->config['js_url'] . 'mgr/templates/grid.templates.js';
                $scripts[] = $this->versionx->config['js_url'] . 'mgr/templatevars/panel.templatevars.js';
                $scripts[] = $this->versionx->config['js_url'] . 'mgr/templatevars/grid.templatevars.js';
                $scripts[] = $this->versionx->config['js_url'] . 'mgr/chunks/panel.chunks.js';
                $scripts[] = $this->versionx->config['js_url'] . 'mgr/chunks/grid.chunks.js';
                $scripts[] = $this->versionx->config['js_url'] . 'mgr/snippets/panel.snippets.js';
                $scripts[] = $this->versionx->config['js_url'] . 'mgr/snippets/grid.snippets.js';
                $scripts[] = $this->versionx->config['js_url'] . 'mgr/plugins/panel.plugins.js';
                $scripts[] = $this->versionx->config['js_url'] . 'mgr/plugins/grid.plugins.js';
                $this->addLastJavascript($this->versionx->config['js_url'] . 'mgr/action.index.js' . $cachebust);
                break;
        }

        foreach ($scripts as $url) {
            $this->addJavascript($url . $cachebust);
        }
    }
}