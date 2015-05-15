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

$_lang['versionx.home'] = 'VersionX';
$_lang['versionx.home.text'] = 'VersionX is a utility tool for MODX Revolution that will help you keep track of your content in Resources, Templates, Chunks, Snippets and Plugins. Every save is recorded and can easily be looked back and compared through this component. <br /><br />
VersionX is free software, however your help is needed to keep the development going. If VersionX has proven helpful, please <a href="http://www.markhamstra.com/open-source/versionx/">consider making a donation</a> to support VersionX. Thank you.';

$_lang['versionx.common.empty'] = '&lt;empty&gt;';
$_lang['versionx.common.version-details'] = 'Version Details';
$_lang['versionx.common.detail.text'] = 'Below you can find the details for the [[+what]] Version you selected. To compare this Version with another one, use the combobox below to select another Version.';
$_lang['versionx.common.fields'] = 'Fields';
$_lang['versionx.common.content'] = 'Content';
$_lang['versionx.common.properties'] = 'Properties';
$_lang['versionx.common.properties.off'] = 'Sorry, we can\'t show you this tab yet';

$_lang['versionx.resources.detail'] = 'Resource Details';
$_lang['versionx.resources.detail.text'] = 'Below you can find the details for the Resource Version you selected. To compare this Version with another one, use the combobox below to select another Version.';
$_lang['versionx.resources.revert'] = 'Revert Resource to Version #[[+id]]';
$_lang['versionx.resources.revert.options'] = 'Revert Resource';
$_lang['versionx.resources.revert.confirm'] = 'Are you sure?';
$_lang['versionx.resources.revert.confirm.text'] = 'Are you sure you want to revert to Version #[[+id]]? This will overwrite ALL fields and Template Variables currently set for the resource and replace them with the ones in the version you selected.';
$_lang['versionx.resources.reverted'] = 'Resource has been successfully reverted!';

$_lang['versionx.resources.detail.tabs.resource-content.columnheader'] = 'Content for Version #[[+id]]';
$_lang['versionx.resources.detail.tabs.template-variables'] = 'Template Variables';
$_lang['versionx.resources.detail.tabs.page-settings'] = 'Page Settings';

$_lang['versionx.resources.detail.grid.columns.field-name'] = 'Field Name';
$_lang['versionx.resources.detail.grid.columns.field-value'] = 'Field Value [Ver #[[+id]]]';

$_lang['versionx.templates.detail'] = 'Template Details';
$_lang['versionx.templates.detail.text'] = 'Below you can find the details for the Template Version you selected. To compare this Version with another one, use the combobox below to select another Version.';
$_lang['versionx.templates.revert'] = 'Revert Template to Version #[[+id]]';
$_lang['versionx.templates.revert.options'] = 'Revert Template';
$_lang['versionx.templates.revert.confirm'] = 'Are you sure?';
$_lang['versionx.templates.revert.confirm.text'] = 'Are you sure you want to revert to Version #[[+id]]? This will overwrite the content and other metadata currently set for the Template and replace them with the ones in the version you selected.';
$_lang['versionx.templates.reverted'] = 'Template has been successfully reverted!';

$_lang['versionx.templatevars.detail.tabs.input-options'] = 'Input Options';
$_lang['versionx.templatevars.detail.tabs.output-options'] = 'Output Options';

$_lang['versionx.templatevars.detail'] = 'Template Variable Details';
$_lang['versionx.templatevars.detail.input-type'] = 'Input Type';
$_lang['versionx.templatevars.detail.input-properties'] = 'Input Properties';
$_lang['versionx.templatevars.detail.default-text'] = 'Default Value';
$_lang['versionx.templatevars.detail.output-type'] = 'Output Type';
$_lang['versionx.templatevars.detail.output-properties'] = 'Output Properties';
$_lang['versionx.templatevars.revert'] = 'Revert Template Variable to Version #[[+id]]';
$_lang['versionx.templatevars.revert.options'] = 'Revert Template Variable';
$_lang['versionx.templatevars.revert.confirm'] = 'Are you sure?';
$_lang['versionx.templatevars.revert.confirm.text'] = 'Are you sure you want to revert to Version #[[+id]]? This will overwrite the content and other metadata currently set for the Template Variable and replace them with the ones in the version you selected.';
$_lang['versionx.templatevars.reverted'] = 'Template Variable has been successfully reverted!';

$_lang['versionx.chunks.detail'] = 'Chunk Details';
$_lang['versionx.chunks.detail.text'] = 'Below you can find the details for the Chunk Version you selected. To compare this Version with another one, use the combobox below to select another Version.';
$_lang['versionx.chunks.revert'] = 'Revert Chunk to Version #[[+id]]';
$_lang['versionx.chunks.revert.options'] = 'Revert Chunk';
$_lang['versionx.chunks.revert.confirm'] = 'Are you sure?';
$_lang['versionx.chunks.revert.confirm.text'] = 'Are you sure you want to revert to Version #[[+id]]? This will overwrite the content and other metadata currently set for the Chunk and replace them with the ones in the version you selected.';
$_lang['versionx.chunks.reverted'] = 'Chunk has been successfully reverted!';

$_lang['versionx.snippets.detail'] = 'Snippet Details';
$_lang['versionx.snippets.detail.text'] = 'Below you can find the details for the Snippet Version you selected. To compare this Version with another one, use the combobox below to select another Version.';
$_lang['versionx.snippets.revert'] = 'Revert Snippet to Version #[[+id]]';
$_lang['versionx.snippets.revert.options'] = 'Revert Snippet';
$_lang['versionx.snippets.revert.confirm'] = 'Are you sure?';
$_lang['versionx.snippets.revert.confirm.text'] = 'Are you sure you want to revert to Version #[[+id]]? This will overwrite the content and other metadata currently set for the Snippet and replace them with the ones in the version you selected.';
$_lang['versionx.snippets.reverted'] = 'Snippet has been successfully reverted!';

$_lang['versionx.plugins.detail'] = 'Plugin Details';
$_lang['versionx.plugins.detail.text'] = 'Below you can find the details for the Plugin Version you selected. To compare this Version with another one, use the combobox below to select another Version.';
$_lang['versionx.plugins.revert'] = 'Revert Plugin to Version #[[+id]]';
$_lang['versionx.plugins.revert.options'] = 'Revert Plugin';
$_lang['versionx.plugins.revert.confirm'] = 'Are you sure?';
$_lang['versionx.plugins.revert.confirm.text'] = 'Are you sure you want to revert to Version #[[+id]]? This will overwrite the content and other metadata currently set for the Plugin and replace them with the ones in the version you selected.';
$_lang['versionx.plugins.reverted'] = 'Plugin has been successfully reverted!';

$_lang['versionx.menu.viewdetails'] = 'View Version Details';
$_lang['versionx.back'] = 'Back to Overview';
$_lang['versionx.backto'] = 'Back to [[+what]]';
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

$_lang['versionx.widget.resources'] = 'Recent Resource Changes';
$_lang['versionx.widget.resources.desc'] = '(Part of VersionX) Shows a grid with the most recent resource changes for all users.';
$_lang['versionx.widget.resources.update'] = 'Update Resource';

// Auto-save related strings. Added after 2012-02-23.
$_lang['versionx.draft_secured'] = 'Draft saved at [[+when]]';
$_lang['versionx.draft_secured.message'] = 'A draft of your edits has been saved. In the event where you need to access the draft, please see the Versions tab.';
$_lang['versionx.draft_secured.error'] = 'Uh oh.. something went wrong in an attempt to auto save your edits.';

// System Settings Added by Josh Gulledge 7-25-12, merged 2013-02-16
$_lang['setting_versionx.debug'] = 'Debug';
$_lang['setting_versionx.debug_desc'] = 'Set to true to see debug messages logged to the MODX Error Log.';
$_lang['setting_versionx.formtabs.resource'] = 'Resource Tab';
$_lang['setting_versionx.formtabs.resource_desc'] = 'Set to true to show VersionX as as a tab when editing a Resource';
$_lang['setting_versionx.formtabs.template'] = 'Template Tab';
$_lang['setting_versionx.formtabs.template_desc'] = 'Set to true to show VersionX as as a tab when editing a Template';
$_lang['setting_versionx.formtabs.templatevariables'] = 'TV Tab';
$_lang['setting_versionx.formtabs.templatevariables_desc'] = 'Set to true to show VersionX as as a tab when editing a Template Variable';
$_lang['setting_versionx.formtabs.chunk'] = 'Chunk Tab';
$_lang['setting_versionx.formtabs.chunk_desc'] = 'Set to true to show VersionX as as a tab when editing a Chunk';
$_lang['setting_versionx.formtabs.snippet'] = 'Snippet Tab';
$_lang['setting_versionx.formtabs.snippet_desc'] = 'Set to true to show VersionX as as a tab when editing a Snippet';
$_lang['setting_versionx.formtabs.plugin'] = 'Plugin Tab';
$_lang['setting_versionx.formtabs.plugin_desc'] = 'Set to true to show VersionX as as a tab when editing a Plugin';

$_lang['setting_versionx.enable.resources'] = 'Enable Resources';
$_lang['setting_versionx.enable.resources_desc'] = 'Set to true to enable VersionX to version Resources';
$_lang['setting_versionx.enable.templates'] = 'Enable Templates';
$_lang['setting_versionx.enable.templates_desc'] = 'Set to true to enable VersionX to version Templates';
$_lang['setting_versionx.enable.templatevariables'] = 'Enable TVs';
$_lang['setting_versionx.enable.templatevariables_desc'] = 'Set to true to enable VersionX to version Template Variables';
$_lang['setting_versionx.enable.chunks'] = 'Enable Chunks';
$_lang['setting_versionx.enable.chunks_desc'] = 'Set to true to enable VersionX to version Chunks';
$_lang['setting_versionx.enable.snippets'] = 'Enable Snippets';
$_lang['setting_versionx.enable.snippets_desc'] = 'Set to true to enable VersionX to version Snippets';
$_lang['setting_versionx.enable.plugins'] = 'Enable Plugins';
$_lang['setting_versionx.enable.plugins_desc'] = 'Set to true to enable VersionX to version Plugins';
