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

        $modxVersion = $this->modx->getVersionData();

        // Set "versionx_mv2" class for CSS if not on MODX 3.x
        $version = '';
        if (version_compare($modxVersion['full_version'], '3.0.0', '<')) {
            $version = <<<HTML
<script type="text/javascript">
window.addEventListener("DOMContentLoaded", function () { document.body.className = document.body.className + ' versionx_mv2'; });
</script>
HTML;
        }

        $this->cacheBust = '?vxv=' . urlencode($this->versionx->config['version']);
        $this->addJavascript($this->versionx->config['js_url'] . 'mgr/versionx.class.js' . $this->cacheBust);
        $this->addHtml('
            ' . $version . '
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