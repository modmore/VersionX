<?php

switch ($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_INSTALL:
    case xPDOTransport::ACTION_UPGRADE:
    case xPDOTransport::ACTION_UNINSTALL: 
    break;
}

$output = <<<HTML
<p>If you already have resources and elements in place, you can let the setup process create a snapshot of them to the VersionX database, providing you with a baseline to start comparing from. The system will check for existing versions and only create a snapshot when needed.</p>
<br />
<p style="font-size: 90%; font-style: italic;">Note: depending on the amount of resources and elements you currently have in place as well as your server's configuration, this process can take quite some time.</p>
<br />
<p>Choose what to create snapshots for:</p>
<div style="padding-left: 20px;">
    <input type="checkbox" name="vx_snapshot_resources" id="vx_snapshot_resources" />
        <label for="vx_snapshot_resources">Resources</label> <br />
    <input type="checkbox" name="vx_snapshot_templates" id="vx_snapshot_templates" />
        <label for="vx_snapshot_templates">Templates</label> <br />
    <input type="checkbox" name="vx_snapshot_chunks" id="vx_snapshot_chunks" />
        <label for="vx_snapshot_chunks">Chunks</label> <br />
    <input type="checkbox" name="vx_snapshot_snippets" id="vx_snapshot_snippets" />
        <label for="vx_snapshot_snippets">Snippets</label> <br />
    <input type="checkbox" name="vx_snapshot_plugins" id="vx_snapshot_plugins" />
        <label for="vx_snapshot_plugins">Plugins</label> <br />
    <input type="checkbox" name="vx_snapshot_tmplvars" id="vx_snapshot_tmplvars" />
        <label for="vx_snapshot_tmplvars">Template Variables</label>
</div>
HTML;

return $output;
