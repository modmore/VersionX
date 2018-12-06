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
        $this->addJavascript($this->versionx->config['js_url'] . 'mgr/resources/panel.resources.js' . $cachebust);
        $this->addJavascript($this->versionx->config['js_url'] . 'mgr/resources/grid.resources.js' . $cachebust);
        $this->addJavascript($this->versionx->config['js_url'] . 'mgr/templates/panel.templates.js' . $cachebust);
        $this->addJavascript($this->versionx->config['js_url'] . 'mgr/templates/grid.templates.js' . $cachebust);
        $this->addJavascript($this->versionx->config['js_url'] . 'mgr/templatevars/panel.templatevars.js' . $cachebust);
        $this->addJavascript($this->versionx->config['js_url'] . 'mgr/templatevars/grid.templatevars.js' . $cachebust);
        $this->addJavascript($this->versionx->config['js_url'] . 'mgr/chunks/panel.chunks.js' . $cachebust);
        $this->addJavascript($this->versionx->config['js_url'] . 'mgr/chunks/grid.chunks.js' . $cachebust);
        $this->addJavascript($this->versionx->config['js_url'] . 'mgr/snippets/panel.snippets.js' . $cachebust);
        $this->addJavascript($this->versionx->config['js_url'] . 'mgr/snippets/grid.snippets.js' . $cachebust);
        $this->addJavascript($this->versionx->config['js_url'] . 'mgr/plugins/panel.plugins.js' . $cachebust);
        $this->addJavascript($this->versionx->config['js_url'] . 'mgr/plugins/grid.plugins.js' . $cachebust);
        $this->addLastJavascript($this->versionx->config['js_url'] . 'mgr/action.index.js' . $cachebust);
    }
}