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
$_lang['versionx.tabheader'] = 'Versioner';
$_lang['versionx.menu_desc'] = 'Holder styr på dit værdifulde indhold.';

$_lang['versionx.home'] = 'VersionX';
$_lang['versionx.home.text'] = 'VersionX er et værktøj til MODX Revolution der hjælper dig med at holde styr på dit indhold i ressourcer, Templates, Chunks, Snippets and Plugins. Enhver gemt ændring bliver registreret og det er nemt at se tilbage og sammenligne versioner gennem denne komponent.<br /><br />
VersionX er gratis software, men din hjælp er nødvendig for at holde udviklingen i gang. Hvis VersionX har hjulpet dig, så <a href="http://www.markhamstra.com/open-source/versionx/">overvej at give en donation</a> for at støtte VersionX. Mange tak.';

$_lang['versionx.common.empty'] = '&lt;tom&gt;';
$_lang['versionx.common.version-details'] = 'Detaljer for version';
$_lang['versionx.common.detail.text'] = 'Herunder finder du detaljer for den [[+what]] version du har valgt. Brug dropdown-boksen herunder for at vælge en anden version at sammenligne denne version med.';
$_lang['versionx.common.fields'] = 'Felter';
$_lang['versionx.common.content'] = 'Indhold';
$_lang['versionx.common.properties'] = 'Egenskaber';
$_lang['versionx.common.properties.off'] = 'Vi kan desværre ikke vise dig dette faneblad endnu.';

$_lang['versionx.resources.detail'] = 'Detaljer for ressource';
$_lang['versionx.resources.detail.text'] = 'Herunder finder du detaljer for den ressource version du har valgt. Brug dropdown-boksen herunder for at vælge en anden version at sammenligne denne version med.';
$_lang['versionx.resources.revert'] = 'Sæt ressourcen tilbage til version #[[+id]]';
$_lang['versionx.resources.revert.options'] = 'Sæt ressourcen tilbage';
$_lang['versionx.resources.revert.confirm'] = 'Er du sikker?';
$_lang['versionx.resources.revert.confirm.text'] = 'Er du sikker på, at du vil gå tilbage til version #[[+id]]? Dette vil overskrive ALLE felter og template-variable med værdierne fra den version du har valgt.';
$_lang['versionx.resources.reverted'] = 'Ressourcen er blevet sat tilbage!';

$_lang['versionx.resources.detail.tabs.resource-content.columnheader'] = 'Indhold af version #[[+id]]';
$_lang['versionx.resources.detail.tabs.template-variables'] = 'Template-variable';
$_lang['versionx.resources.detail.tabs.page-settings'] = 'Sideindstillinger';

$_lang['versionx.resources.detail.grid.columns.field-name'] = 'Feltnavn';
$_lang['versionx.resources.detail.grid.columns.field-value'] = 'Feltværdi [Ver #[[+id]]]';

$_lang['versionx.templates.detail'] = 'Detaljer for template';
$_lang['versionx.templates.detail.text'] = 'Herunder finder du detaljer for den template-version du har valgt. Brug dropdown-boksen herunder for at vælge en anden version at sammenligne denne version med.';
$_lang['versionx.templates.revert'] = 'Sæt templatet tilbage til version #[[+id]]';
$_lang['versionx.templates.revert.options'] = 'Sæt templatet tilbage';
$_lang['versionx.templates.revert.confirm'] = 'Er du sikker?';
$_lang['versionx.templates.revert.confirm.text'] = 'Er du sikker på, at du vil gå tilbage til version #[[+id]]? Dette vil overskrive indhold og andre metadata med værdierne fra den version du har valgt.';
$_lang['versionx.templates.reverted'] = 'Templatet er blevet sat tilbage!';

$_lang['versionx.templatevars.detail.tabs.input-options'] = 'Input-indstillinger';
$_lang['versionx.templatevars.detail.tabs.output-options'] = 'Output-indstillinger';

$_lang['versionx.templatevars.detail'] = 'Detaljer for template-variabel';
$_lang['versionx.templatevars.detail.input-type'] = 'Input-type';
$_lang['versionx.templatevars.detail.input-properties'] = 'Input-indstillinger';
$_lang['versionx.templatevars.detail.default-text'] = 'Standardværdi';
$_lang['versionx.templatevars.detail.output-type'] = 'Output-type';
$_lang['versionx.templatevars.detail.output-properties'] = 'Output-indstillinger';
$_lang['versionx.templatevars.revert'] = 'Sæt template-variablen tilbage til version #[[+id]]';
$_lang['versionx.templatevars.revert.options'] = 'Sæt template-variablen tilbage';
$_lang['versionx.templatevars.revert.confirm'] = 'Er du sikker?';
$_lang['versionx.templatevars.revert.confirm.text'] = 'Er du sikker på, at du vil gå tilbage til version #[[+id]]? Dette vil overskrive indhold og andre metadata med værdierne fra den version du har valgt.';
$_lang['versionx.templatevars.reverted'] = 'Template-variablen er blevet sat tilbage!';

$_lang['versionx.chunks.detail'] = 'Detaljer for chunk';
$_lang['versionx.chunks.detail.text'] = 'Herunder finder du detaljer for den chunk-version du har valgt. Brug dropdown-boksen herunder for at vælge en anden version at sammenligne denne version med.';
$_lang['versionx.chunks.revert'] = 'Sæt chunken tilbage til version #[[+id]]';
$_lang['versionx.chunks.revert.options'] = 'Sæt chunken tilbage';
$_lang['versionx.chunks.revert.confirm'] = 'Er du sikker?';
$_lang['versionx.chunks.revert.confirm.text'] = 'Er du sikker på, at du vil gå tilbage til version #[[+id]]? Dette vil overskrive indhold og andre metadata med værdierne fra den version du har valgt.';
$_lang['versionx.chunks.reverted'] = 'Chunken er blevet sat tilbage!';

$_lang['versionx.snippets.detail'] = 'Detaljer for snippet';
$_lang['versionx.snippets.detail.text'] = 'Herunder finder du detaljer for den snippet-version du har valgt. Brug dropdown-boksen herunder for at vælge en anden version at sammenligne denne version med.';
$_lang['versionx.snippets.revert'] = 'Sæt snippet\'en tilbage til version #[[+id]]';
$_lang['versionx.snippets.revert.options'] = 'Sæt snippet\'en tilbage';
$_lang['versionx.snippets.revert.confirm'] = 'Er du sikker?';
$_lang['versionx.snippets.revert.confirm.text'] = 'Er du sikker på, at du vil gå tilbage til version #[[+id]]? Dette vil overskrive indhold og andre metadata med værdierne fra den version du har valgt.';
$_lang['versionx.snippets.reverted'] = 'Snippet\'en er blevet sat tilbage!';

$_lang['versionx.plugins.detail'] = 'Detaljer for plugin';
$_lang['versionx.plugins.detail.text'] = 'Herunder finder du detaljer for den plugin version du har valgt. Brug dropdown-boksen herunder for at vælge en anden version at sammenligne denne version med.';
$_lang['versionx.plugins.revert'] = 'Sæt plugin\'et tilbage til version #[[+id]]';
$_lang['versionx.plugins.revert.options'] = 'Sæt plugin\'et tilbage';
$_lang['versionx.plugins.revert.confirm'] = 'Er du sikker?';
$_lang['versionx.plugins.revert.confirm.text'] = 'Er du sikker på, at du vil gå tilbage til version #[[+id]]? Dette vil overskrive indhold og andre metadata med værdierne fra den version du har valgt.';
$_lang['versionx.plugins.reverted'] = 'Plugin\'et er blevet sat tilbage!';

$_lang['versionx.menu.viewdetails'] = 'Vis detaljer for version';
$_lang['versionx.back'] = 'Tilbage til oversigten';
$_lang['versionx.backto'] = 'Tilbage til [[+what]]';
$_lang['versionx.compare_to'] = 'Sammenlign med';
$_lang['versionx.compare_this_version_to'] = 'Sammenlign denne version med';
$_lang['versionx.filter'] = 'Filtrér [[+what]]';
$_lang['versionx.filter.reset'] = 'Nulstil filter';
$_lang['versionx.filter.datefrom'] = 'Fra';
$_lang['versionx.filter.dateuntil'] = 'Til';

$_lang['versionx.version_id'] = 'Version ID';
$_lang['versionx.content_id'] = '[[+what]] ID';
$_lang['versionx.content_name'] = '[[+what]] navn';
$_lang['versionx.mode'] = 'Tilstand';
$_lang['versionx.mode.new'] = 'Opret';
$_lang['versionx.mode.upd'] = 'Opdater';
$_lang['versionx.mode.snapshot'] = 'Snapshot';
$_lang['versionx.mode.revert'] = 'Sat tilbage';
$_lang['versionx.saved'] = 'Gemt på';
$_lang['versionx.title'] = 'Titel';
$_lang['versionx.marked'] = 'Markeret';

$_lang['versionx.error.noresults'] = 'Der blev ikke fundet nogle resultater.';
$_lang['versionx.tabtip.notyet'] = 'Vi kan desværre ikke vise dig historikken for [[+what]] endnu. Men tag det roligt, ændringer bliver allerede overvåget og så snart vi tilføjer dette faneblad er kan du se dem!';

$_lang['versionx.widget.resources'] = 'Seneste ressourceændringer';
$_lang['versionx.widget.resources.desc'] = '(Del af VersionX) Viser en tabel med de seneste ressourceændringer for alle brugere.';
$_lang['versionx.widget.resources.update'] = 'Opdater ressource';
