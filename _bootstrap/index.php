<?php
/* Get the core config */
if (!file_exists(dirname(dirname(__FILE__)).'/config.core.php')) {
    die('ERROR: missing '.dirname(dirname(__FILE__)).'/config.core.php file defining the MODX core path.');
}

echo "<pre>";
/* Boot up MODX */
echo "Loading modX...\n";
require_once dirname(dirname(__FILE__)).'/config.core.php';
require_once MODX_CORE_PATH.'model/modx/modx.class.php';
$modx = new modX();
echo "Initializing manager...\n";
$modx->initialize('mgr');
$modx->getService('error','error.modError', '', '');

$componentPath = dirname(dirname(__FILE__));

$VersionX = $modx->getService('versionx','VersionX', $componentPath.'/core/components/versionx/model/versionx/', array(
    'versionx.core_path' => $componentPath.'/core/components/versionx/',
));


/* Namespace */
if (!createObject('modNamespace',array(
    'name' => 'versionx',
    'path' => $componentPath.'/core/components/versionx/',
    'assets_path' => $componentPath.'/assets/components/versionx/',
),'name', false)) {
    echo "Error creating namespace versionx.\n";
}

/* Path settings */
if (!createObject('modSystemSetting', array(
    'key' => 'versionx.core_path',
    'value' => $componentPath.'/core/components/versionx/',
    'xtype' => 'textfield',
    'namespace' => 'versionx',
    'area' => 'Paths',
    'editedon' => time(),
), 'key', false)) {
    echo "Error creating versionx.core_path setting.\n";
}

if (!createObject('modSystemSetting', array(
    'key' => 'versionx.assets_path',
    'value' => $componentPath.'/assets/components/versionx/',
    'xtype' => 'textfield',
    'namespace' => 'versionx',
    'area' => 'Paths',
    'editedon' => time(),
), 'key', false)) {
    echo "Error creating versionx.assets_path setting.\n";
}

/* Fetch assets url */
$url = 'http';
if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on')) {
    $url .= 's';
}
$url .= '://'.$_SERVER["SERVER_NAME"];
if ($_SERVER['SERVER_PORT'] != '80') {
    $url .= ':'.$_SERVER['SERVER_PORT'];
}
$requestUri = $_SERVER['REQUEST_URI'];
$bootstrapPos = strpos($requestUri, '_bootstrap/');
$requestUri = rtrim(substr($requestUri, 0, $bootstrapPos), '/').'/';
$assetsUrl = "{$url}{$requestUri}assets/components/versionx/";

if (!createObject('modSystemSetting', array(
    'key' => 'versionx.assets_url',
    'value' => $assetsUrl,
    'xtype' => 'textfield',
    'namespace' => 'versionx',
    'area' => 'Paths',
    'editedon' => time(),
), 'key', false)) {
    echo "Error creating versionx.assets_url setting.\n";
}

if (!createObject('modPlugin', array(
    'name' => 'VersionX',
    'static' => true,
    'static_file' => $componentPath.'/core/components/versionx/elements/plugins/versionx.plugin.php',
), 'name', true)) {
    echo "Error creating VersionX Plugin.\n";
}
$vcPlugin = $modx->getObject('modPlugin', array('name' => 'VersionX'));
if ($vcPlugin) {
    $pluginId = $vcPlugin->get('id');

    $events = array(
        'OnDocFormSave',
        'OnTempFormSave',
        'OnTVFormSave',
        'OnChunkFormSave',
        'OnSnipFormSave',
        'OnPluginFormSave',

        'OnDocFormPrerender',
        'OnTempFormPrerender',
        'OnTVFormPrerender',
        'OnChunkFormPrerender',
        'OnSnipFormPrerender',
        'OnPluginFormPrerender',
    );

    foreach ($events as $event) {
        if (!createObject('modPluginEvent', array(
            'pluginid' => $pluginId,
            'event' => $event,
            'priority' => 0,
        ), array('pluginid','event'), false)) {
            echo "Error creating modPluginEvent $event.\n";
        }
    }
}

// Menu

if (!createObject('modAction', array(
    'namespace' => 'versionx',
    'parent' => '0',
    'controller' => 'controllers/index',
    'haslayout' => '1',
    'lang_topics' => 'versionx:default',
    'assets' => '',
), 'namespace', false)) {
    echo "Error creating action.\n";
}
$action = $modx->getObject('modAction', array(
    'namespace' => 'versionx'
));

if ($action) {
    if (!createObject('modMenu', array(
        'text' => 'versionx',
        'parent' => 'components',
        'description' => 'versionx.menu_desc',
        'icon' => 'images/icons/plugin.gif',
        'menuindex' => '0',
        'action' => $action->get('id')
    ), 'text', false)) {
        echo "Error creating menu.\n";
    }
}

$settings = include dirname(dirname(__FILE__)).'/_build/data/settings.php';
foreach ($settings as $key => $opts) {
    if (!createObject('modSystemSetting', array(
        'key' => 'versionx.' . $key,
        'value' => $opts['value'],
        'xtype' => (isset($opts['xtype'])) ? $opts['xtype'] : 'textfield',
        'namespace' => 'versionx',
        'area' => $opts['area'],
        'editedon' => time(),
    ), 'key', false)) {
        echo "Error creating versionx.".$key." setting.\n";
    }
}


$manager = $modx->getManager();


/* Create the tables */
$objectContainers = array(
    'vxChunk',
    'vxPlugin',
    'vxResource',
    'vxSnippet',
    'vxTemplate',
    'vxTemplateVar',
);
echo "Creating tables...\n";

foreach ($objectContainers as $oC) {
    $manager->createObjectContainer($oC);
}

echo "Done.";


/**
 * Creates an object.
 *
 * @param string $className
 * @param array $data
 * @param string $primaryField
 * @param bool $update
 * @return bool
 */
function createObject ($className = '', array $data = array(), $primaryField = '', $update = true) {
    global $modx;
    /* @var xPDOObject $object */
    $object = null;

    /* Attempt to get the existing object */
    if (!empty($primaryField)) {
        $condition = array($primaryField => $data[$primaryField]);
        if (is_array($primaryField)) {
            $condition = array();
            foreach ($primaryField as $key) {
                $condition[$key] = $data[$key];
            }
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
