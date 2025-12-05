<?php

/* Get the core config */
if (!file_exists(dirname(__DIR__) . '/config.core.php')) {
    die('ERROR: missing ' . dirname(__DIR__) . '/config.core.php file defining the MODX core path.');
}

echo "<pre>";
/* Boot up MODX */
echo "Loading modX...\n";
require_once dirname(__DIR__) . '/config.core.php';
require_once MODX_CORE_PATH . 'model/modx/modx.class.php';
$modx = new modX();
echo "Initializing manager...\n";
$modx->initialize('mgr');
$modx->getService('error', 'error.modError', '', '');

$componentPath = dirname(__DIR__);

$versionx = $modx->getService('versionx', 'VersionX', $componentPath . '/core/components/versionx/model/', [
    'versionx.core_path' => $componentPath . '/core/components/versionx/',
]);


/* Namespace */
if (!createObject('modNamespace', [
    'name' => 'versionx',
    'path' => $componentPath . '/core/components/versionx/',
    'assets_path' => $componentPath . '/assets/components/versionx/',
], 'name', true)) {
    echo "Error creating namespace versionx.\n";
}

/* Path settings */
if (!createObject('modSystemSetting', [
    'key' => 'versionx.core_path',
    'value' => $componentPath . '/core/components/versionx/',
    'xtype' => 'textfield',
    'namespace' => 'versionx',
    'area' => 'Paths',
    'editedon' => time(),
], 'key', false)) {
    echo "Error creating versionx.core_path setting.\n";
}

if (!createObject('modSystemSetting', [
    'key' => 'versionx.assets_path',
    'value' => $componentPath . '/assets/components/versionx/',
    'xtype' => 'textfield',
    'namespace' => 'versionx',
    'area' => 'Paths',
    'editedon' => time(),
], 'key', false)) {
    echo "Error creating versionx.assets_path setting.\n";
}

/* Fetch assets url */
$url = 'http';
if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on')) {
    $url .= 's';
}
$url .= '://' . $_SERVER["SERVER_NAME"];
if ($_SERVER['SERVER_PORT'] != '80') {
    $url .= ':' . $_SERVER['SERVER_PORT'];
}
$requestUri = $_SERVER['REQUEST_URI'];
$bootstrapPos = strpos($requestUri, '_bootstrap/');
$requestUri = rtrim(substr($requestUri, 0, $bootstrapPos), '/') . '/';
$assetsUrl = "{$url}{$requestUri}assets/components/versionx/";

if (!createObject('modSystemSetting', [
    'key' => 'versionx.assets_url',
    'value' => $assetsUrl,
    'xtype' => 'textfield',
    'namespace' => 'versionx',
    'area' => 'Paths',
    'editedon' => time(),
], 'key', false)) {
    echo "Error creating versionx.assets_url setting.\n";
}
if (!createObject('modPlugin', [
    'name' => 'VersionX',
    'static' => true,
    'static_file' => $componentPath . '/core/components/versionx/elements/plugins/versionx.plugin.php',
], 'name', true)) {
    echo "Error creating VersionX Plugin.\n";
}
$vcPlugin = $modx->getObject('modPlugin', ['name' => 'VersionX']);
if ($vcPlugin) {
    $events = [
        'OnMODXInit',
        'OnDocFormSave',
        'OnTempFormSave',
        'OnTVFormSave',
        'OnChunkFormSave',
        'OnSnipFormSave',
        'OnPluginFormSave',
        'OnSiteRefresh',
        'OnDocFormPrerender',
        'OnTempFormPrerender',
        'OnTVFormPrerender',
        'OnChunkFormPrerender',
        'OnSnipFormPrerender',
        'OnPluginFormPrerender',
    ];
    foreach ($events as $event) {
        if (!createObject('modPluginEvent', [
            'pluginid' => $vcPlugin->get('id'),
            'event' => $event,
            'priority' => 0,
        ], ['pluginid', 'event'], false)) {
            echo "Error creating modPluginEvent {$event}.\n";
        }
    }
}

if (!createObject('modMenu', [
    'text' => 'versionx',
    'parent' => 'components',
    'description' => 'versionx.menu_desc',
    'action' => 'index',
    'namespace' => 'versionx',
], 'text', true)) {
    echo "Error creating menu.\n";
}

$settings = include $componentPath . '/_build/data/settings.php';
foreach ($settings as $key => $opts) {
    $val = $opts['value'];

    if (isset($opts['xtype'])) $xtype = $opts['xtype'];
    elseif (is_int($val)) $xtype = 'numberfield';
    elseif (is_bool($val)) $xtype = 'modx-combo-boolean';
    else $xtype = 'textfield';

    if (!createObject('modSystemSetting', [
        'key' => 'versionx.' . $key,
        'value' => $opts['value'],
        'xtype' => $xtype,
        'namespace' => 'versionx',
        'area' => $opts['area'],
    ], 'key', false)) {
        echo "Error creating versionx." . $key . " setting.\n";
    }
}

// Widgets
$widgets = include $componentPath . '/_build/data/transport.dashboardwidgets.php';
if (empty($widgets))  {
    $modx->log(modX::LOG_LEVEL_ERROR, 'Could not create widgets.');
}
foreach ($widgets as $key => $obj) {
    /** @var modDashboardWidget $obj */
    if (!createObject(modDashboardWidget::class, $obj->toArray(), 'name', false)) {
        echo "Error creating " . $obj->get('name') . " widget.\n";
    }
}

$modx->setLogLevel(2);

/* Create the tables */
$objectContainers = [
    vxDelta::class,
    vxDeltaEditor::class,
    vxDeltaField::class,

    // The rest are deprecated but kept for now to allow migrations
    'vxResource',
    'vxTemplate',
    'vxSnippet',
    'vxChunk',
    'vxPlugin',
    'vxTemplateVar'
];
echo "Creating tables...\n";
$manager = $modx->getManager();
foreach ($objectContainers as $oC) {
    $manager->createObjectContainer($oC);
}

// VersionX 3.1.3
// These fields are added to keep track of data types to be used when reverting
$modx->setLogLevel(modX::LOG_LEVEL_FATAL);
$manager->addField('vxDeltaField', 'before_type', ['after' => 'field_type']);
$manager->addField('vxDeltaField', 'after_type', ['after' => 'before_type']);

// VersionX 3.3.0
// Remove explicit CURRENT_TIMESTAMP default on datetime fields for compatibility with MariaDB
$manager->alterField('vxDelta', 'time_start');
$manager->alterField('vxDelta', 'time_end');

$modx->setLogLevel(modX::LOG_LEVEL_ERROR);

echo "Done.\n";

// Refresh the cache
$modx->cacheManager->refresh();


/**
 * Creates an object.
 *
 * @param string $className
 * @param array $data
 * @param string $primaryField
 * @param bool $update
 * @return bool
 */
function createObject($className = '', array $data = [], $primaryField = '', $update = true)
{
    global $modx;
    /* @var xPDOObject $object */
    $object = null;

    /* Attempt to get the existing object */
    if (!empty($primaryField)) {
        if (is_array($primaryField)) {
            $condition = [];
            foreach ($primaryField as $key) {
                $condition[$key] = $data[$key];
            }
        } else {
            $condition = [$primaryField => $data[$primaryField]];
        }
        $object = $modx->getObject($className, $condition);
        if ($object instanceof $className) {
            if ($update) {
                $object->fromArray($data);
                return $object->save();
            } else {
                $condition = $modx->toJSON($condition);
                echo "Skipping {$className} {$condition}: already exists.\n";
                return true;
            }
        }
    }

    /* Create new object if it doesn't exist */
    if (!$object) {
        $object = $modx->newObject($className);
        $object->fromArray($data, '', true);
        return $object->save();
    }

    return false;
}
