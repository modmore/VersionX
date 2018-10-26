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
 * VersionX 2.0.0rc1 German language file contributed by luk
 *
 * @package versionx
 */

$_lang['versionx'] = 'VersionX';
$_lang['versionx.tabheader'] = 'Versionen';
$_lang['versionx.menu_desc'] = 'Sichert ihren wertvollen Inhalt.';

$_lang['versionx.home'] = 'VersionX';
$_lang['versionx.home.text'] = 'VersionX ist ein nützliches Werkzeug für MODX Revolution, das Ihnen hilft den Überblick über ihre Inhalte in Ressourcen, Templates, Chunks, Snippets und Plugins zu behalten. Jeder Speichervorgang wird aufgezeichnet und kann leicht verglichen und wiederhergestellt bzw. rückgängig gemacht werden. Bitte beachten Sie, dass die Schnittstelle für Chunks, Snippets und Plugins noch nicht enthalten ist, die Daten werden in der Datenbank gespeichert und stehen zur Verfügung, sobald die Funktionen implementiert sind. <br /> <br />
	VersionX steht kostenlos (und Open Source) zur Verfügung, jedoch wurde eine Menge Zeit in Entwicklung, Wartung und Support investiert. Bitte <a href="http://www.markhamstra.com/open-source/versionx/">denken Sie über eine Spende nach</a> und unterstützen Sie die zukünftige Weiterentwicklung von VersionX';

$_lang['versionx.common.empty'] = '&lt;leer&gt;';
$_lang['versionx.common.version-details'] = 'Version Details';
$_lang['versionx.common.detail.text'] = 'Unten finden Sie die Details für die [[+what]]-Version, die Sie ausgewählt haben. Um diese Version mit einer anderen zu vergleichen, wählen Sie über die Combobox unten eine andere Version aus.';
$_lang['versionx.common.fields'] = 'Felder';
$_lang['versionx.common.content'] = 'Inhalt';
$_lang['versionx.common.properties'] = 'Eigenschaften';
$_lang['versionx.common.properties.off'] = 'Entschuldigung, dieser Tab kann noch nicht angezeigt werden.';

$_lang['versionx.resources.detail'] = 'Ressourcendetails';
$_lang['versionx.resources.detail.text'] = 'Unten finden Sie Details zur ausgewählten Ressourcenversion. Um diese Version mit einer anderen zu vergleichen, wählen Sie über die Combobox unten eine andere Version aus.';
$_lang['versionx.resources.revert'] = 'Zurücksetzen auf Version #[[+id]]';
$_lang['versionx.resources.revert.options'] = 'Ressource zurücksetzen';
$_lang['versionx.resources.revert.confirm'] = 'Sind Sie sicher?';
$_lang['versionx.resources.revert.confirm.text'] = 'Sind Sie sicher, dass Sie zur Version #[[+id]] zurückkehren wollen? Dies überschreibt ALLE Felder und Template Variablen, die momentan für die Ressource festgelegt sind, und ersetzt die Werte mit denjenigen in der ausgewählten Ressourcenversion.';
$_lang['versionx.resources.reverted'] = 'Ressourcenversion erfolgreich wiederhergestellt!';

$_lang['versionx.resources.detail.tabs.resource-content.columnheader'] = 'Content für Version #[[+id]]';
$_lang['versionx.resources.detail.tabs.template-variables'] = 'Template Variablen';
$_lang['versionx.resources.detail.tabs.page-settings'] = 'Seiteneinstellungen';

$_lang['versionx.resources.detail.grid.columns.field-name'] = 'Feldname';
$_lang['versionx.resources.detail.grid.columns.field-value'] = 'Feldinhalt [Ver #[[+id]]]';

$_lang['versionx.templates.detail'] = 'Template Details';
$_lang['versionx.templates.detail.text'] = 'Unten finden Sie Details zur ausgewählten Template-Version. Um diese Version mit einer anderen zu vergleichen, wählen Sie über die Combobox unten eine andere Version aus.';
$_lang['versionx.templates.revert'] = 'Template auf Version #[[+id]] zurücksetzen';
$_lang['versionx.templates.revert.options'] = 'Template zurücksetzen';
$_lang['versionx.templates.revert.confirm'] = 'Sicher?';
$_lang['versionx.templates.revert.confirm.text'] = 'Sind Sie sicher, dass Sie zur Version #[[+id]] zurückkehren wollen? Dies überschreibt den Inhalt und sämtliche anderen Metadaten dieses Templates und ersetzt Sie mit denjenigen aus Version #[[+id]]!';
$_lang['versionx.templates.reverted'] = 'Template erfolgreich auf Version #[[+id]] zurückgesetzt!';

$_lang['versionx.templatevars.detail.tabs.input-options'] = 'Eingabe-Optionen';
$_lang['versionx.templatevars.detail.tabs.output-options'] = 'Ausgabe-Optionen';
$_lang['versionx.templatevars.detail'] = 'Template Variable Details';
$_lang['versionx.templatevars.detail.input-type'] = 'Eingabetyp';
$_lang['versionx.templatevars.detail.input-properties'] = 'Eingabe-Optionswerte';
$_lang['versionx.templatevars.detail.default-text'] = 'Standardwert';
$_lang['versionx.templatevars.detail.output-type'] = 'Ausgabetyp';
$_lang['versionx.templatevars.detail.output-properties'] = 'Ausgabe-Optionswerte';
$_lang['versionx.templatevars.revert'] = 'Template Variable auf Version #[[+id]] zurücksetzen';
$_lang['versionx.templatevars.revert.options'] = 'Template Variable zurücksetzen';
$_lang['versionx.templatevars.revert.confirm'] = 'Sicher?';
$_lang['versionx.templatevars.revert.confirm.text'] = 'Sind Sie sicher, dass Sie zur Version #[[+id]] zurückkehren wollen? Dies überschreibt den Inhalt und sämtliche anderen Metadaten dieser Template Variable und ersetzt Sie mit denjenigen aus Version #[[+id]]!';
$_lang['versionx.templatevars.reverted'] = 'Template Variable erfolgreich auf Version #[[+id]] zurückgesetzt!';

$_lang['versionx.chunks.detail'] = 'Chunk Details';
$_lang['versionx.chunks.detail.text'] = 'Unten finden Sie Details zur ausgewählten Chunk-Version. Um diese Version mit einer anderen zu vergleichen, wählen Sie über die Combobox unten eine andere Version aus.';
$_lang['versionx.chunks.revert'] = 'Chunk auf Version #[[+id]] zurücksetzen';
$_lang['versionx.chunks.revert.options'] = 'Chunk zurücksetzen';
$_lang['versionx.chunks.revert.confirm'] = 'Sicher?';
$_lang['versionx.chunks.revert.confirm.text'] = 'Sind Sie sicher, dass Sie zur Version #[[+id]] zurückkehren wollen? Dies überschreibt den Inhalt und sämtliche anderen Metadaten dieses Chunks und ersetzt Sie mit denjenigen aus Version #[[+id]]!';
$_lang['versionx.chunks.reverted'] = 'Chunk erfolgreich auf Version #[[+id]] zurückgesetzt!';

$_lang['versionx.snippets.detail'] = 'Snippet Details';
$_lang['versionx.snippets.detail.text'] = 'Unten finden Sie Details zur ausgewählten Snippet-Version. Um diese Version mit einer anderen zu vergleichen, wählen Sie über die Combobox unten eine andere Version aus.';
$_lang['versionx.snippets.revert'] = 'Snippet auf Version #[[+id]] zurücksetzen';
$_lang['versionx.snippets.revert.options'] = 'Snippet zurücksetzen';
$_lang['versionx.snippets.revert.confirm'] = 'Sicher?';
$_lang['versionx.snippets.revert.confirm.text'] = 'Sind Sie sicher, dass Sie zur Version #[[+id]] zurückkehren wollen? Dies überschreibt den Inhalt und sämtliche anderen Metadaten dieses Snippets und ersetzt Sie mit denjenigen aus Version #[[+id]]!';
$_lang['versionx.snippets.reverted'] = 'Snippet erfolgreich auf Version #[[+id]] zurückgesetzt!';

$_lang['versionx.plugins.detail'] = 'Plugin Details';
$_lang['versionx.plugins.detail.text'] = 'Unten finden Sie Details zur ausgewählten Plugin-Version. Um diese Version mit einer anderen zu vergleichen, wählen Sie über die Combobox unten eine andere Version aus.';
$_lang['versionx.plugins.revert'] = 'Plugin auf Version #[[+id]] zurücksetzen';
$_lang['versionx.plugins.revert.options'] = 'Plugin zurücksetzen';
$_lang['versionx.plugins.revert.confirm'] = 'Sicher?';
$_lang['versionx.plugins.revert.confirm.text'] = 'Sind Sie sicher, dass Sie zur Version #[[+id]] zurückkehren wollen? Dies überschreibt den Inhalt und sämtliche anderen Metadaten dieses Plugins und ersetzt Sie mit denjenigen aus Version #[[+id]]!';
$_lang['versionx.plugins.reverted'] = 'Plugin erfolgreich auf Version #[[+id]] zurückgesetzt!';

$_lang['versionx.menu.viewdetails'] = 'Version Details ansehen';
$_lang['versionx.back'] = 'Zurück zur Übersicht';
$_lang['versionx.backto'] = 'Zurück zu [[+what]]';
$_lang['versionx.compare_to'] = 'Vergleichen mit';
$_lang['versionx.compare_this_version_to'] = 'Diese Version vergleichen mit';
$_lang['versionx.filter'] = '[[+what]] filtern';
$_lang['versionx.filter.reset'] = 'Filter zurücksetzen';
$_lang['versionx.filter.datefrom'] = 'Von';
$_lang['versionx.filter.dateuntil'] = 'Bis';

$_lang['versionx.version_id'] = 'Version ID';
$_lang['versionx.content_id'] = '[[+what]] ID';
$_lang['versionx.content_name'] = '[[+what]] Name';
$_lang['versionx.mode'] = 'Art';
$_lang['versionx.mode.new'] = 'Erstellen';
$_lang['versionx.mode.upd'] = 'Aktualisieren';
$_lang['versionx.mode.snapshot'] = 'Snapshot';
$_lang['versionx.mode.revert'] = 'Zurückgesetzt';
$_lang['versionx.saved'] = 'Gespeichert am';
$_lang['versionx.title'] = 'Titel';
$_lang['versionx.marked'] = 'Markiert';

$_lang['versionx.error.noresults'] = 'Für ihre Anfrage konnten keine Resultate gefunden werden.';
$_lang['versionx.tabtip.notyet'] = 'Entschuldigung, leider kann die Historie für [[+what]] noch nicht angezeigt werden. Veränderungen werden jedoch bereits jetzt in die Datenbank geschrieben – sobald diese Funktionen implementiert sind, werden sie hier angezeigt!';

$_lang['versionx.widget.resources'] = 'Kürzliche Ressourcenveränderungen';
$_lang['versionx.widget.resources.desc'] = '(Teil von VersionX) Zeigt eine Tabelle mit den letzten Änderungen aller User.';
$_lang['versionx.widget.resources.update'] = 'Ressource aktualisieren';
