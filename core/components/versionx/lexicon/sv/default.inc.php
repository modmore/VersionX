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
 * @subpackage lexicon-sv
 * @author Joakim Nyman <joakim+versionx@fractalwolfe.com>
 * @date 2012-09-06
 */

$_lang['versionx'] = 'VersionX';
$_lang['versionx.tabheader'] = 'Versioner';
$_lang['versionx.menu_desc'] = 'Håller koll på ditt värdefulla innehåll.';

$_lang['versionx.common.empty'] = '&lt;tom&gt;';
$_lang['versionx.common.version-details'] = 'Versionsinformation';
$_lang['versionx.common.detail.text'] = 'Nedan hittar du informationen för den [[+what]] version du har valt. För att jämföra denna version med en annan, använd rullgardinsmenyn nedan för att välja en annan version.';

$_lang['versionx.home'] = 'VersionX';
$_lang['versionx.home.text'] = 'VersionX är ett verktyg för MODX Revolution som hjälper dig att hålla koll på ditt innehåll i Resurser, Mallar, Chunks, Snippets, och Plugins. Varje lagring registreras och kan enkelt redovisas och jämföras genom denna komponent. Vänligen notera, att medans gränssnittet för Chunks, Snippets och Plugins inte ännu är inkluderat, så registreras och lagras de i databasen för framtida användning.<br /><br />
Även om VersionX är gratis att använda (och öppen källkod), her mycket tid gått åt till utveckling, underhåll och att erbjuda support. Vänligen <a href="http://www.markhamstra.com/open-source/versionx/">överväg att göra en donation</a> för att stödja VersionX framöver.';

$_lang['versionx.resources.detail'] = 'Resursinformation';
$_lang['versionx.resources.detail.text'] = 'Nedan hittar du all information för den resursversion du har valt. För att jämföra denna version med en annan, använd rullgardinslistan nedan för att välja en annan version.';
$_lang['versionx.resources.revert'] = 'Återställ resurs till version #[[+id]]';
$_lang['versionx.resources.revert.options'] = 'Återställ resurs';
$_lang['versionx.resources.revert.confirm'] = 'Är du säker?';
$_lang['versionx.resources.revert.confirm.text'] = 'Är du säker att du vill återställa till version #[[+id]]? Denna kommer att skriva över ALLA fält och Mallvariabler som är angivna för resursen och ersätta dem med värdena från den version du har valt.';
$_lang['versionx.resources.reverted'] = 'Resursen återställdes framgångsrikt!';

$_lang['versionx.resources.detail.tabs.resource-fields'] = 'Fält';
$_lang['versionx.resources.detail.tabs.resource-content'] = 'Innehåll';
$_lang['versionx.resources.detail.tabs.resource-content.columnheader'] = 'Innehåll för version #[[+id]]';
$_lang['versionx.resources.detail.tabs.template-variables'] = 'Mallvariabler';
$_lang['versionx.resources.detail.tabs.page-settings'] = 'Sidinställningar';

$_lang['versionx.resources.detail.grid.columns.field-name'] = 'Fält namn';
$_lang['versionx.resources.detail.grid.columns.field-value'] = 'Fält värde [Ver #[[+id]]]';

$_lang['versionx.templates.detail.tabs.fields'] = 'Fält';
$_lang['versionx.templates.detail.tabs.content'] = 'Innehåll';
$_lang['versionx.templates.detail.tabs.properties'] = 'Egenskaper';
$_lang['versionx.templates.detail.tabs.properties.off'] = 'Vi beklagar, vi kan inte visa denna flik åt dig ännu';
$_lang['versionx.templates.detail'] = 'Mallinformation';
$_lang['versionx.templates.detail.text'] = 'Nedan hittar du informationen för den mallversion du har valt. För att jämföra denna version med en annan, använd rullgardinslistan nedan för att välja en annan version.';

$_lang['versionx.templatevars.detail.tabs.input-options'] = 'Inmatningsalternativ';
$_lang['versionx.templatevars.detail.tabs.output-options'] = 'Utskriftsalternativ';
$_lang['versionx.templatevars.detail.tabs.properties'] = 'Egenskaper';
$_lang['versionx.templatevars.detail.tabs.properties.off'] = 'Vi beklagar, vi kan inte visa denna flik åt dig ännu';

$_lang['versionx.templatevars.detail'] = 'Mallvariabelinformation';
$_lang['versionx.templatevars.detail.input-type'] = 'Inmatningstyp';
$_lang['versionx.templatevars.detail.input-properties'] = 'Inmatningsegenskaper';
$_lang['versionx.templatevars.detail.default-text'] = 'Standardvärde';
$_lang['versionx.templatevars.detail.output-type'] = 'Utskriftstyp';
$_lang['versionx.templatevars.detail.output-properties'] = 'Utskriftsegenskaper';

$_lang['versionx.chunks.detail.tabs.fields'] = 'Fält';
$_lang['versionx.chunks.detail.tabs.content'] = 'Innehåll';
$_lang['versionx.chunks.detail.tabs.properties'] = 'Egenskaper';
$_lang['versionx.chunks.detail.tabs.properties.off'] = 'Vi beklagar, vi kan inte visa denna flik åt dig ännu';
$_lang['versionx.chunks.detail'] = 'Chunkinformation';
$_lang['versionx.chunks.detail.text'] = 'Nedan hittar du informationen för den chunkversion du har valt. För att jämföra denna version med en annan, använd rullgardinslistan nedan för att välja en annan version.';

$_lang['versionx.menu.viewdetails'] = 'Visa versionsinformation';
$_lang['versionx.back'] = 'Tillbaka till översikt';
$_lang['versionx.backto'] = 'Tillbaka till [[+what]]';
$_lang['versionx.compare_to'] = 'Jämför med';
$_lang['versionx.compare_this_version_to'] = 'Jämför denna version med';
$_lang['versionx.filter'] = 'Filtrera [[+what]]';
$_lang['versionx.filter.reset'] = 'Nollställ filter';
$_lang['versionx.filter.datefrom'] = 'Från';
$_lang['versionx.filter.dateuntil'] = 'Till';

$_lang['versionx.version_id'] = 'Versions ID';
$_lang['versionx.content_id'] = '[[+what]] ID';
$_lang['versionx.content_name'] = '[[+what]] namn';
$_lang['versionx.mode'] = 'Läge';
$_lang['versionx.mode.new'] = 'Skapa';
$_lang['versionx.mode.upd'] = 'Uppdatera';
$_lang['versionx.mode.snapshot'] = 'Snapshot';
$_lang['versionx.mode.revert'] = 'Återställd';
$_lang['versionx.saved'] = 'Sparad';
$_lang['versionx.title'] = 'Titel';
$_lang['versionx.marked'] = 'Märkt';

$_lang['versionx.error.noresults'] = 'Inga resultat hittades för din sökning.';
$_lang['versionx.tabtip.notyet'] = 'Vi beklagar, vi kan inte visa din [[+what]] historik ännu. Men du kan vara lugn - förändringar övervakas redan, så när vi väl lägger till denna flik är det bara att köra!';

$_lang['versionx.widget.resources'] = 'Senaste resursändringarna';
$_lang['versionx.widget.resources.desc'] = '(Del av VersionX) Visar en tabell över de senaste resursförändringarna för alla användare.';
$_lang['versionx.widget.resources.update'] = 'Uppdatera resurs';
