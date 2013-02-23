<?php
$plugins = array();

/** create the plugin object */
$plugins[0] = $modx->newObject('modPlugin');
$plugins[0]->set('id',1);
$plugins[0]->set('name','VersionX');
$plugins[0]->set('description','The plugin that enables VersionX of tracking your content.');
$plugins[0]->set('plugincode', getSnippetContent($sources['plugins'] . 'versionx.plugin.php'));
$plugins[0]->set('category', 0);

$events = include $sources['events'].'events.versionx.php';
if (is_array($events) && !empty($events)) {
    $plugins[0]->addMany($events);
    $modx->log(xPDO::LOG_LEVEL_INFO,'Packaged in '.count($events).' Plugin Events for VersionX.'); flush();
} else {
    $modx->log(xPDO::LOG_LEVEL_ERROR,'Could not find plugin events for VersionX!');
}
unset($events);

return $plugins;
