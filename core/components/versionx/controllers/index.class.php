<?php

use modmore\VersionX\VersionX;

class VersionXIndexManagerController extends modExtraManagerController
{
    /** @var VersionX */
    protected VersionX $versionx;
    protected string $cacheBust;

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
        ');
    }

    public function loadCustomCssJs()
    {
        $this->addJavascript($this->versionx->config['js_url'] . 'mgr/grid.deltas.js' . $this->cacheBust);
        $this->addJavascript($this->versionx->config['js_url'] . 'mgr/window.deltas.js' . $this->cacheBust);
        $this->addJavascript($this->versionx->config['js_url'] . 'mgr/grid.objects.js' . $this->cacheBust);
        $this->addLastJavascript($this->versionx->config['js_url'] . 'mgr/index.js' . $this->cacheBust);
        $this->addCss($this->versionx->config['css_url'] . 'mgr/mgr.css');


    }

    public function getLanguageTopics(): array
    {
        return ['versionx:default'];
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