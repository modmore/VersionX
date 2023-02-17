<?php

require_once __DIR__ . '/base.class.php';

class VersionXIndexManagerController extends VersionXBaseManagerController
{
    public function loadCustomCssJs()
    {
        $this->addJavascript($this->versionx->config['js_url'] . 'mgr/resources/panel.resources.js' . $this->cacheBust);
        $this->addJavascript($this->versionx->config['js_url'] . 'mgr/resources/grid.resources.js' . $this->cacheBust);
        $this->addJavascript($this->versionx->config['js_url'] . 'mgr/templates/panel.templates.js' . $this->cacheBust);
        $this->addJavascript($this->versionx->config['js_url'] . 'mgr/templates/grid.templates.js' . $this->cacheBust);
        $this->addJavascript($this->versionx->config['js_url'] . 'mgr/templatevars/panel.templatevars.js' . $this->cacheBust);
        $this->addJavascript($this->versionx->config['js_url'] . 'mgr/templatevars/grid.templatevars.js' . $this->cacheBust);
        $this->addJavascript($this->versionx->config['js_url'] . 'mgr/chunks/panel.chunks.js' . $this->cacheBust);
        $this->addJavascript($this->versionx->config['js_url'] . 'mgr/chunks/grid.chunks.js' . $this->cacheBust);
        $this->addJavascript($this->versionx->config['js_url'] . 'mgr/snippets/panel.snippets.js' . $this->cacheBust);
        $this->addJavascript($this->versionx->config['js_url'] . 'mgr/snippets/grid.snippets.js' . $this->cacheBust);
        $this->addJavascript($this->versionx->config['js_url'] . 'mgr/plugins/panel.plugins.js' . $this->cacheBust);
        $this->addJavascript($this->versionx->config['js_url'] . 'mgr/plugins/grid.plugins.js' . $this->cacheBust);
        $this->addLastJavascript($this->versionx->config['js_url'] . 'mgr/action.index.js' . $this->cacheBust);
        $this->addCss($this->versionx->config['css_url'] . 'mgr/mgr.css');
    }
}