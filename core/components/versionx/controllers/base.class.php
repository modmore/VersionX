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

    public function initialize()
    {
        $this->versionx = new VersionX($this->modx);

        $this->addHtml('
                <script type="text/javascript">
                    Ext.onReady(function() {
                        VersionX.config = '.$this->modx->toJSON($this->versionx->config).';
                        VersionX.action = '. 1 .';
                    });
                </script>

                <style type="text/css">
                    .ext-gecko .x-form-text, .ext-ie8 .x-form-text {padding-top: 0;}
                    .vx-added .x-form-item-label { color: green; }
                    .vx-changed .x-form-item-label { color: #dd6600; }
                    .vx-removed .x-form-item-label { color: #ff0000; }
                </style>');

        $this->addJavascript($this->versionx->config['js_url'].'mgr/versionx.class.js');
        $this->addJavascript($this->versionx->config['js_url'].'mgr/common/json2.js');
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

}