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
 * @package versionx
 */

$_lang['versionx'] = 'VersionX';
$_lang['versionx.tabheader'] = 'Versions';
$_lang['versionx.menu_desc'] = 'Keeps track of your valuable content.';

$_lang['versionx.common.empty'] = '&lt;empty&gt;';

$_lang['versionx.home'] = 'VersionX';
$_lang['versionx.home.text'] = 'VersionX is a utility tool for MODX Revolution that will help you keep track of your content in Resources, Templates, Chunks, Snippets and Plugins. Every save is recorded and can easily be looked back and compared through this component. Please note that, while the interface for Chunks, Snippets and Plugins are not yet included, they are actually being recorded and stored in the database for future use.<br /><br />
While VersionX is free to use (and open source), a lot of time has gone into development, maintenance and offering support. Please <a href="http://www.markhamstra.com/open-source/versionx/">consider making a donation</a> to support VersionX going forward.';

$_lang['versionx.common.detail.text'] = 'Below you can find the details for the [[+what]] Version you selected. To compare this Version with another one, use the combobox below to select another Version.';

$_lang['versionx.resources.detail'] = 'Resource Details';
$_lang['versionx.resources.detail.text'] = 'Below you can find the details for the Resource Version you selected. To compare this Version with another one, use the combobox below to select another Version.';
$_lang['versionx.resources.revert'] = 'Revert Resource to Version #[[+id]]';
$_lang['versionx.resources.revert.options'] = 'Revert Resource';
$_lang['versionx.resources.revert.confirm'] = 'Are you sure?';
$_lang['versionx.resources.revert.confirm.text'] = 'Are you sure you want to revert to Version #[[+id]]? This will overwrite ALL fields and Template Variables currently set for the resource and replace them with the ones in the version you selected.';
$_lang['versionx.resources.reverted'] = 'Resource has been reverted';

$_lang['versionx.resources.detail.tabs.version-details'] = 'Version Details';
$_lang['versionx.resources.detail.tabs.resource-fields'] = 'Fields';
$_lang['versionx.resources.detail.tabs.resource-content'] = 'Content';
$_lang['versionx.resources.detail.tabs.resource-content.columnheader'] = 'Content for Version #[[+id]]';
$_lang['versionx.resources.detail.tabs.template-variables'] = 'Template Variables';
$_lang['versionx.resources.detail.tabs.page-settings'] = 'Page Settings';

$_lang['versionx.resources.detail.grid.columns.field-name'] = 'Field Name';
$_lang['versionx.resources.detail.grid.columns.field-value'] = 'Field Value [Ver #[[+id]]]';

$_lang['versionx.templates.detail.tabs.version-details'] = 'Version Details';
$_lang['versionx.templates.detail.tabs.fields'] = 'Fields';
$_lang['versionx.templates.detail.tabs.content'] = 'Content';
$_lang['versionx.templates.detail.tabs.properties'] = 'Properties';
$_lang['versionx.templates.detail.tabs.properties.off'] = 'Sorry, we can\'t show you this tab yet';

$_lang['versionx.templates.detail'] = 'Template Details';
$_lang['versionx.templates.detail.text'] = 'Below you can find the details for the Template Version you selected. To compare this Version with another one, use the combobox below to select another Version.';

$_lang['versionx.templatevars.detail.tabs.version-details'] = 'Version Details';
$_lang['versionx.templatevars.detail.tabs.input-options'] = 'Input Options';
$_lang['versionx.templatevars.detail.tabs.output-options'] = 'Output Options';
$_lang['versionx.templatevars.detail.tabs.properties'] = 'Properties';
$_lang['versionx.templatevars.detail.tabs.properties.off'] = 'Sorry, we can\'t show you this tab yet';

$_lang['versionx.templatevars.detail'] = 'Template Variable Details';
$_lang['versionx.templatevars.detail.input-type'] = 'Input Type';
$_lang['versionx.templatevars.detail.input-properties'] = 'Input Properties';
$_lang['versionx.templatevars.detail.default-text'] = 'Default Value';
$_lang['versionx.templatevars.detail.output-type'] = 'Output Type';
$_lang['versionx.templatevars.detail.output-properties'] = 'Output Properties';

$_lang['versionx.menu.viewdetails'] = 'View Version Details';
$_lang['versionx.back'] = 'Back to Overview';
$_lang['versionx.backtoresource'] = 'Back to Resource';
$_lang['versionx.compare_to'] = 'Compare To';
$_lang['versionx.compare_this_version_to'] = 'Compare this version to';
$_lang['versionx.filter'] = 'Filter [[+what]]';
$_lang['versionx.filter.reset'] = 'Reset Filter';
$_lang['versionx.filter.datefrom'] = 'From';
$_lang['versionx.filter.dateuntil'] = 'Until';

$_lang['versionx.version_id'] = 'Version ID';
$_lang['versionx.content_id'] = '[[+what]] ID';
$_lang['versionx.content_name'] = '[[+what]] Name';
$_lang['versionx.mode'] = 'Mode';
$_lang['versionx.mode.new'] = 'Create';
$_lang['versionx.mode.upd'] = 'Update';
$_lang['versionx.mode.snapshot'] = 'Snapshot';
$_lang['versionx.mode.revert'] = 'Reverted';
$_lang['versionx.saved'] = 'Saved On';
$_lang['versionx.title'] = 'Title';
$_lang['versionx.marked'] = 'Marked';

$_lang['versionx.error.noresults'] = 'No results found for your query.';
$_lang['versionx.tabtip.notyet'] = 'Sorry, we can\'t show you your [[+what]] history yet. Rest assured though - changes are already being monitored, and once we add this tab you\'re good to go!';

?>
