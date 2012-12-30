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
 * @language cs
 *
 * @author modxcms.cz
 * @updated 2012-12-30
 */

$_lang['versionx'] = 'VersionX';
$_lang['versionx.tabheader'] = 'Verze';
$_lang['versionx.menu_desc'] = 'Sledování stavu vašeho obsahu.';

$_lang['versionx.home'] = 'VersionX';
$_lang['versionx.home.text'] = 'VersionX je nástroj pro MODX Revolution, který pomáhá sledovat změny v obsahu Dokumentů, Šablon, Chunků, Snippetů a Pluginů. Každé uložení je zaznamenáno a v rámci tohoto nástroje je možno jednoduše tyto změny porovnat. <br /><br />
VersionX je svobodný software, avšak vaše pomoc je stále potřeba, aby se vývoj nezastavil. Pokud je pro vás VersionX užitečný,  <a href="http://www.markhamstra.com/open-source/versionx/">zvažte poskytnutí daru</a> na podporu VersionX. Děkuji.';

$_lang['versionx.common.empty'] = '&lt;prázdný&gt;';
$_lang['versionx.common.version-details'] = 'Podrobnosti verze';
$_lang['versionx.common.detail.text'] = 'Níže naleznete podrobnosti o verzi [[+what]], kterou jste vybrali. Pro srovnání s jinou verzí použijte rozbalovací nabídky pod tímto textem.';
$_lang['versionx.common.fields'] = 'Pole';
$_lang['versionx.common.content'] = 'Obsah';
$_lang['versionx.common.properties'] = 'Vlastnosti';
$_lang['versionx.common.properties.off'] = 'Je nám líto, ale tuto záložku zatím nelze zobrazit';

$_lang['versionx.resources.detail'] = 'Podrobnosti dokumentu';
$_lang['versionx.resources.detail.text'] = 'Níže naleznete podrobnosti o verzi Dokumentu, kterou jste vybrali. Pro srovnání s jinou verzí použijte rozbalovací nabídky pod tímto textem.';
$_lang['versionx.resources.revert'] = 'Vrátit se k verzi #[[+id]]';
$_lang['versionx.resources.revert.options'] = 'Vrátit verzi dokumentu';
$_lang['versionx.resources.revert.confirm'] = 'Opravdu chcete?';
$_lang['versionx.resources.revert.confirm.text'] = 'Opravdu chcete vrátit verzi #[[+id]]? Dojde k nahrazení VŠECH aktuálních údajů a Template Variables v tomto Dokumentu údaji a hodnotami Template Variables z vybrané verze.';
$_lang['versionx.resources.reverted'] = 'Dokument byl úspěšně navrácen!';

$_lang['versionx.resources.detail.tabs.resource-content.columnheader'] = 'Obsha pro verzi #[[+id]]';
$_lang['versionx.resources.detail.tabs.template-variables'] = 'Template Variables';
$_lang['versionx.resources.detail.tabs.page-settings'] = 'Nastavení';

$_lang['versionx.resources.detail.grid.columns.field-name'] = 'Název pole';
$_lang['versionx.resources.detail.grid.columns.field-value'] = 'Hodnota pole [Ver #[[+id]]]';

$_lang['versionx.templates.detail'] = 'Podrobnosti šablony';
$_lang['versionx.templates.detail.text'] = 'Níže naleznete podrobnosti o verzi Šablony, kterou jste vybrali. Pro srovnání s jinou verzí použijte rozbalovací nabídky pod tímto textem.';
$_lang['versionx.templates.revert'] = 'Vrátit se k verzi #[[+id]]';
$_lang['versionx.templates.revert.options'] = 'Vrátit verzi Šablony';
$_lang['versionx.templates.revert.confirm'] = 'Opravdu chcete?';
$_lang['versionx.templates.revert.confirm.text'] = 'Opravdu chcete vrátit verzi #[[+id]]? Dojde k přepsání aktuálního obsahu a ostatních metadat v této Šabloně obsahem a metadaty z vybrané verze.';
$_lang['versionx.templates.reverted'] = 'Šablona byla úspěšně navrácena!';

$_lang['versionx.templatevars.detail.tabs.input-options'] = 'Možnosti vstupu';
$_lang['versionx.templatevars.detail.tabs.output-options'] = 'Možnosti výstupu';

$_lang['versionx.templatevars.detail'] = 'Podrobnosti Template Variable';
$_lang['versionx.templatevars.detail.input-type'] = 'Typ vstupu';
$_lang['versionx.templatevars.detail.input-properties'] = 'Výchozí hodnota vstupu';
$_lang['versionx.templatevars.detail.default-text'] = 'Výchozí hodnota';
$_lang['versionx.templatevars.detail.output-type'] = 'Typ výstupu';
$_lang['versionx.templatevars.detail.output-properties'] = 'Výchozí hodnota výstupu';
$_lang['versionx.templatevars.revert'] = 'Vrátit se k verzi #[[+id]]';
$_lang['versionx.templatevars.revert.options'] = 'Vrátit verzi Template Variable';
$_lang['versionx.templatevars.revert.confirm'] = 'Opravdu chcete?';
$_lang['versionx.templatevars.revert.confirm.text'] = 'Opravdu chcete vrátit verzi #[[+id]]? Dojde k přepsání aktuálního obsahu a ostatních metadat v této Template Variable obsahem a metadaty z vybrané verze.';
$_lang['versionx.templatevars.reverted'] = 'Template Variable byla úspěšně navrácena!';

$_lang['versionx.chunks.detail'] = 'Podrobnosti Chunku';
$_lang['versionx.chunks.detail.text'] = 'Níže naleznete podrobnosti o verzi Chunku, kterou jste vybrali. Pro srovnání s jinou verzí použijte rozbalovací nabídky pod tímto textem.';
$_lang['versionx.chunks.revert'] = 'Vrátit se k verzi #[[+id]]';
$_lang['versionx.chunks.revert.options'] = 'Vrátit verzi Chunku';
$_lang['versionx.chunks.revert.confirm'] = 'Opravdu chcete?';
$_lang['versionx.chunks.revert.confirm.text'] = 'Opravdu chcete vrátit verzi #[[+id]]? Dojde k přepsání aktuálního obsahu a ostatních metadat v tomto Chunku obsahem a metadaty z vybrané verze.';
$_lang['versionx.chunks.reverted'] = 'Chunk byl úspěšně navrácen!';

$_lang['versionx.snippets.detail'] = 'Podrobnosti Snippetu';
$_lang['versionx.snippets.detail.text'] = 'Níže naleznete podrobnosti o verzi Snippetu, kterou jste vybrali. Pro srovnání s jinou verzí použijte rozbalovací nabídky pod tímto textem.';
$_lang['versionx.snippets.revert'] = 'Vrátit se k verzi #[[+id]]';
$_lang['versionx.snippets.revert.options'] = 'Vrátit verzi Snippetu';
$_lang['versionx.snippets.revert.confirm'] = 'Opravdu chcete?';
$_lang['versionx.snippets.revert.confirm.text'] = 'Opravdu chcete vrátit verzi #[[+id]]? Dojde k přepsání aktuálního obsahu a ostatních metadat v tomto Snippetu obsahem a metadaty z vybrané verze.';
$_lang['versionx.snippets.reverted'] = 'Snippet byl úspěšně navrácen!';

$_lang['versionx.plugins.detail'] = 'Podrobnosti Pluginu';
$_lang['versionx.plugins.detail.text'] = 'Níže naleznete podrobnosti o verzi Pluginu, kterou jste vybrali. Pro srovnání s jinou verzí použijte rozbalovací nabídky pod tímto textem.';
$_lang['versionx.plugins.revert'] = 'Vrátit se k verzi #[[+id]]';
$_lang['versionx.plugins.revert.options'] = 'Vrátit verzi Pluginu';
$_lang['versionx.plugins.revert.confirm'] = 'Opravdu chcete?';
$_lang['versionx.plugins.revert.confirm.text'] = 'Opravdu chcete vrátit verzi #[[+id]]? Dojde k přepsání aktuálního obsahu a ostatních metadat v tomto Pluginu obsahem a metadaty z vybrané verze.';
$_lang['versionx.plugins.reverted'] = 'Plugin byl úspěšně navrácen!';

$_lang['versionx.menu.viewdetails'] = 'Zobrazit podrobnosti verze';
$_lang['versionx.back'] = 'Zpět na přehled';
$_lang['versionx.backto'] = 'Zpět na [[+what]]';
$_lang['versionx.compare_to'] = 'Porovnat s';
$_lang['versionx.compare_this_version_to'] = 'Porovnat tuto verzi s verzí';
$_lang['versionx.filter'] = 'Filtrovat [[+what]]';
$_lang['versionx.filter.reset'] = 'Resetovat filtr';
$_lang['versionx.filter.datefrom'] = 'Od';
$_lang['versionx.filter.dateuntil'] = 'Do';

$_lang['versionx.version_id'] = 'ID verze';
$_lang['versionx.content_id'] = '[[+what]] ID';
$_lang['versionx.content_name'] = 'Název [[+what]]';
$_lang['versionx.mode'] = 'Mód';
$_lang['versionx.mode.new'] = 'Nový';
$_lang['versionx.mode.upd'] = 'Uložen';
$_lang['versionx.mode.snapshot'] = 'Snímek';
$_lang['versionx.mode.revert'] = 'Navrácen';
$_lang['versionx.saved'] = 'Uložen';
$_lang['versionx.title'] = 'Titulek';
$_lang['versionx.marked'] = 'Označen';

$_lang['versionx.error.noresults'] = 'Pro dotaz nebylo nic nalezeno.';
$_lang['versionx.tabtip.notyet'] = 'Je nám líto, ale v současnou chvíli vám nelze zobrazit historii [[+what]]. Ujišťujeme vás, že změny jsou již sledovány, jakmile přidáme tuto záložku budete mít data dostupná!';

$_lang['versionx.widget.resources'] = 'Poslední změny dokumentu';
$_lang['versionx.widget.resources.desc'] = '(Součást VersionX) Zobrazí tabulku s nejnověji změněnými dokumenty bez rozlišení uživatelů.';
$_lang['versionx.widget.resources.update'] = 'Upravit dokument';
