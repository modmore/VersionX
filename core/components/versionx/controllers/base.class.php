<?php

use modmore\VersionX\VersionX;

abstract class VersionXBaseManagerController extends modExtraManagerController {
    /** @var VersionX */
    protected VersionX $versionx;
    protected string $cacheBust;
    public $targetClass = null;

    public function initialize()
    {
        $this->versionx = new VersionX($this->modx);

        $this->cacheBust = '?vxv=' . urlencode($this->versionx->config['version']);
        $this->addJavascript($this->versionx->config['js_url'] . 'mgr/versionx.class.js' . $this->cacheBust);
        $this->addHtml('
            <script type="text/javascript">
                Ext.onReady(function() {
                    VersionX.config = ' . json_encode($this->versionx->config) . ';
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

        $this->addJavascript($this->versionx->config['js_url'] . 'mgr/versionx.class.js' . $this->cacheBust);
        $this->addJavascript($this->versionx->config['js_url'] . 'mgr/common/json2.js' . $this->cacheBust);
        $this->addJavascript($this->versionx->config['js_url'] . 'mgr/common/window.common.js' . $this->cacheBust);
        $this->addJavascript($this->versionx->config['js_url'] . 'mgr/common/panel.common.js' . $this->cacheBust);
        $this->addJavascript($this->versionx->config['js_url'] . 'mgr/common/grid.common.js' . $this->cacheBust);
        $this->addJavascript($this->versionx->config['js_url'] . 'mgr/common/panel.content.js' . $this->cacheBust);
        $this->addJavascript($this->versionx->config['js_url'] . 'mgr/resources/detailpanel/panel.tvs.js' . $this->cacheBust);
        $this->addJavascript($this->versionx->config['js_url'] . 'mgr/resources/detailpanel.v21.resources.js' . $this->cacheBust);
        $this->addJavascript($this->versionx->config['js_url'] . 'mgr/resources/combo.versions.resources.js' . $this->cacheBust);
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

    public function getLanguageTopics(): array
    {
        return [
            'versionx:default'
        ];
    }

    public function getPageTitle(): ?string
    {
        return $this->modx->lexicon('versionx');
    }

    public function getTemplateFile(): string
    {
        return $this->versionx->config['core_path'] . 'templates/mgr/versionx.tpl';
    }

}