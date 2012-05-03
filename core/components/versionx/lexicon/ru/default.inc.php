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
 * @subpackage lexicon-ru
 * @language ru
 * @author Ivan Klimchuk (Alroniks, ivan@klimchuk.com)
 * @date 2012-05-03
 *
 */

$_lang['versionx'] = 'VersionX';
$_lang['versionx.tabheader'] = 'Версии';
$_lang['versionx.menu_desc'] = 'Отслеживает изменения вашего ценного контента.';

$_lang['versionx.common.empty'] = '&lt;ничего&gt;';

$_lang['versionx.home'] = 'VersionX';
$_lang['versionx.home.text'] = 'VersionX это утилита для MODX Revolution, которая поможет вам отслеживать и хранить ваше содержимое в Ресурсах, Шаблонах, Чанках, Сниппетах и Плагинах. Каждое сохранение фиксируется и может легко быть просмотрено и сравнено с помощью этого компонента. Обратите внимание, что хотя интерфес для Чанков, Сниппетов и Плагинов еще не включен, они на самом деле записываются и хранятся в базе данных для использования в будущем.<br /><br />
Несмотря на то, что VersionX можно свободно использовать (и это open source), много времени было вложено в разработку,обслуживание и поддержку. Пожалуйста, <a href="http://www.markhamstra.com/open-source/versionx/">рассмотрите возможность пожертвований</a> для дальнейшей поддержки VersionX.';

$_lang['versionx.common.detail.text'] = 'Ниже вы можете найти подробности для версии [[+what]], которую вы выбрали. Для сравнения этой версии с другой используйте выпадающий список ниже, чтобы выбрать другую версию.';

$_lang['versionx.resources.detail'] = 'Подробнее о ресурсе';
$_lang['versionx.resources.detail.text'] = 'Ниже вы можете найти подробности для версии ресурса, которую вы выбрали. Для сравнения этой версии с другой используйте выпадающий список ниже, чтобы выбрать другую версию.';
$_lang['versionx.resources.revert'] = 'Восстановить ресурс до версии #[[+id]]';
$_lang['versionx.resources.revert.options'] = 'Восстановить ресурс';
$_lang['versionx.resources.revert.confirm'] = 'Вы уверены?';
$_lang['versionx.resources.revert.confirm.text'] = 'Вы уверены в том, что хотите подтвердить версию #[[+id]]? Это перезапишет ВСЕ поля и переменные шаблона, установленные сейчас для этого ресурса.';
$_lang['versionx.resources.reverted'] = 'Ресурс был восстановлен';

$_lang['versionx.resources.detail.tabs.version-details'] = 'Детали версии';
$_lang['versionx.resources.detail.tabs.resource-fields'] = 'Поля';
$_lang['versionx.resources.detail.tabs.resource-content'] = 'Содержимое';
$_lang['versionx.resources.detail.tabs.resource-content.columnheader'] = 'Содержимое для версии #[[+id]]';
$_lang['versionx.resources.detail.tabs.template-variables'] = 'Переменные шаблона';
$_lang['versionx.resources.detail.tabs.page-settings'] = 'Настройки страницы';

$_lang['versionx.resources.detail.grid.columns.field-name'] = 'Имя поля';
$_lang['versionx.resources.detail.grid.columns.field-value'] = 'Значение поля [Версия #[[+id]]]';

$_lang['versionx.templates.detail.tabs.version-details'] = 'Детали версии';
$_lang['versionx.templates.detail.tabs.fields'] = 'Поля';
$_lang['versionx.templates.detail.tabs.content'] = 'Содержимое';
$_lang['versionx.templates.detail.tabs.properties'] = 'Свойства';
$_lang['versionx.templates.detail.tabs.properties.off'] = 'К сожалению, мы еще не можем показать вам эту вкладку';

$_lang['versionx.templates.detail'] = 'Детали шаблона';
$_lang['versionx.templates.detail.text'] = 'Ниже вы можете найти подробности для версии шаблона, которую вы выбрали. Для сравнения этой версии с другой используйте выпадающий список ниже, чтобы выбрать другую версию.';

$_lang['versionx.templatevars.detail.tabs.version-details'] = 'Детали версии';
$_lang['versionx.templatevars.detail.tabs.input-options'] = 'Входные параметры';
$_lang['versionx.templatevars.detail.tabs.output-options'] = 'Выходные параметры';
$_lang['versionx.templatevars.detail.tabs.properties'] = 'Свойства';
$_lang['versionx.templatevars.detail.tabs.properties.off'] = 'К сожалению, мы еще не можем показать вам эту вкладку';

$_lang['versionx.templatevars.detail'] = 'Детали переменной шаблона';
$_lang['versionx.templatevars.detail.input-type'] = 'Тип ввода';
$_lang['versionx.templatevars.detail.input-properties'] = 'Параметры ввода';
$_lang['versionx.templatevars.detail.default-text'] = 'Значение по умолчанию';
$_lang['versionx.templatevars.detail.output-type'] = 'Тип вывода';
$_lang['versionx.templatevars.detail.output-properties'] = 'Параметры вывода';

$_lang['versionx.menu.viewdetails'] = 'Просмотр деталей версии';
$_lang['versionx.back'] = 'Назад к списку';
$_lang['versionx.backtoresource'] = 'Вернуться к ресурсу';
$_lang['versionx.compare_to'] = 'Сравнить с';
$_lang['versionx.compare_this_version_to'] = 'Сравнить эту версию с';
$_lang['versionx.filter'] = 'Фильтр по разделу "[[+what]]"';
$_lang['versionx.filter.reset'] = 'Сбросить фильтр';
$_lang['versionx.filter.datefrom'] = 'с';
$_lang['versionx.filter.dateuntil'] = 'по';

$_lang['versionx.version_id'] = 'ID версии';
$_lang['versionx.content_id'] = '[[+what]] ID';
$_lang['versionx.content_name'] = 'Имя [[+what]]';
$_lang['versionx.mode'] = 'Режим';
$_lang['versionx.mode.new'] = 'Создание';
$_lang['versionx.mode.upd'] = 'Обновление';
$_lang['versionx.mode.snapshot'] = 'Слепок';
$_lang['versionx.mode.revert'] = 'Восстановление';
$_lang['versionx.saved'] = 'Сохранено';
$_lang['versionx.title'] = 'Название';
$_lang['versionx.marked'] = 'Отмечено';

$_lang['versionx.error.noresults'] = 'Ничего не найдено по вашему запросу.';
$_lang['versionx.tabtip.notyet'] = 'К сожалению, мы еще не можем показать вам историю [[+what]]. Будьте уверены - изменения уже котролируются и как только мы добавим эту вкладку у вас все будет работать!';

?>
