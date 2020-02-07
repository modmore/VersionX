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

require_once dirname(__DIR__).'/model/versionx.class.php';

abstract class VersionXBaseManagerController extends modExtraManagerController {
    /** @var VersionX */
    protected $versionx;
    public $targetClass = null;

    public function initialize()
    {
        $this->versionx = new VersionX($this->modx);

        $this->addHtml('
            <script type="text/javascript">
                Ext.onReady(function() {
                    VersionX.config = '.$this->modx->toJSON($this->versionx->config).';
                });
            </script>

            <style type="text/css">
                .vx-added { 
                    color: #007500;
                    font-weight: bold !important;
                }
                .vx-removed { 
                    color: #750300;
                    font-weight: bold !important;
                }
                .vx-error-panel {
                    background: #ffdbdb;
                    padding: 1em;
                    border: 1px solid #830000;
                    border-radius: 3px;
                    color: #5a2a2a;
                }
            </style>');

        $this->addJavascript($this->versionx->config['js_url'].'mgr/versionx.class.js');
        $this->addJavascript($this->versionx->config['js_url'].'mgr/common/json2.js');
        $this->addJavascript($this->versionx->config['assets_url'].'node_modules/diff/dist/diff.js');


        $versionid = isset($_REQUEST['vid']) ? (int)$_REQUEST['vid'] : false;
        $compareid = isset($_REQUEST['cmid']) ? (int)$_REQUEST['cmid'] : false;

        /* If an ID was passed, fetch that version into a record array. */
        if ($versionid > 0) {
            $v = $this->versionx->getVersionDetails($this->targetClass, $versionid, true);
            if ($v !== false) {
                $this->addHtml('<script type="text/javascript">VersionX.record = ' . $v . '; </script>');
            }
        }
        /* If an ID to compare to was passed, fetch that aswell. */
        if ($compareid > 0) {
            $v = $this->versionx->getVersionDetails($this->targetClass, $compareid, true);
            if ($v !== false) {
                $this->addHtml('<script type="text/javascript">VersionX.cmrecord = ' . $v . '; </script>');
            }
        }
    }

    public function getLanguageTopics()
    {
        return [
            'versionx:default'
        ];
    }

    public function getPageTitle()
    {
        return $this->modx->lexicon('versionx');
    }

    public function getTemplateFile()
    {
        return $this->versionx->config['core_path'] . 'templates/mgr/versionx.tpl';
    }

}