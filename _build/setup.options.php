<?php

switch ($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_INSTALL:
    case xPDOTransport::ACTION_UPGRADE:

$output = <<<HTML
<style>
    .versionx-header {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: -30px;
    }
    .versionx-header .version {
        position: relative;
        bottom: 15px;
        right: 5px;
        color: #fff;
        background: #ff9640 !important;
        border-radius: 50%;
        width: 25px;
        height: 25px;
        text-align: center;
        vertical-align: center;
        line-height: 24px;
        font-size: 20px;
        box-shadow: 1px 1px 2px rgba(0, 0, 0, 0.15);
    }
</style>
<div class="versionx-header">
    <h2>VersionX</h2>
    <div class="version">3</div>
</div>
<p style="font-size: 90%; font-style: italic;">Resource and element versioning for MODX</p>
<br>
<p style="font-weight: bold;">Migrating from version 2.x</p>
<p>VersionX 3 is a complete rewrite from version 2 and a command line migration script is included to migrate your data to the new version. After installing, from the command line, run: <br><br><pre style="background: #f8fafc; padding: 5px 15px; border-radius: 3px;">php core/components/versionx/migrate.php</pre></p>
<br>
<p>If you already have resources and elements in place, you can let the setup process create a snapshot of them to the VersionX tables, providing you with a baseline to start comparing from. The system will check for existing versions and only create a snapshot when needed.</p>
<br>
<p style="font-size: 90%; font-style: italic;">Note: depending on the amount of resources and elements you currently have in place as well as your server's configuration, this process can take quite some time.</p>
<br>
<p>Choose what to create snapshots for:</p>
<div style="padding-left: 20px;">
    <input type="checkbox" name="vx_snapshot_resources" id="vx_snapshot_resources" />
        <label for="vx_snapshot_resources" style="display: inline;">Resources</label> <br />
    <input type="checkbox" name="vx_snapshot_templates" id="vx_snapshot_templates" />
        <label for="vx_snapshot_templates" style="display: inline;">Templates</label> <br />
    <input type="checkbox" name="vx_snapshot_chunks" id="vx_snapshot_chunks" />
        <label for="vx_snapshot_chunks" style="display: inline;">Chunks</label> <br />
    <input type="checkbox" name="vx_snapshot_snippets" id="vx_snapshot_snippets" />
        <label for="vx_snapshot_snippets" style="display: inline;">Snippets</label> <br />
    <input type="checkbox" name="vx_snapshot_plugins" id="vx_snapshot_plugins" />
        <label for="vx_snapshot_plugins" style="display: inline;">Plugins</label> <br />
    <input type="checkbox" name="vx_snapshot_tmplvars" id="vx_snapshot_tmplvars" />
        <label for="vx_snapshot_tmplvars" style="display: inline;">Template Variables</label>
</div>

<p style="margin-top: 15px;">If you found VersionX useful, please consider <a href="https://modmore.com/extras/versionx/donate/">making a donation to support its development</a>. Thank you!</p>
<br>
<p style="background: red; color: white; font-weight: bold; padding: 5px 15px;">This version is still in beta and is not yet ready for production environments. Only install this on test environments until the stable version is released!</p>

HTML;
    break;
    default:
    case xPDOTransport::ACTION_UNINSTALL:
        $output = '';
    break;
}

return $output;
