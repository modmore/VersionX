<?php

$mtime = microtime();
$mtime = explode(" ", $mtime);
$mtime = $mtime[1] + $mtime[0];
$tstart = $mtime;
set_time_limit(0);


if (!defined('MOREPROVIDER_BUILD')) {
    /* define version */
    define('PKG_NAME', 'VersionX');
    define('PKG_NAMESPACE', 'versionx');
    define('PKG_VERSION', '3.0.0');
    define('PKG_RELEASE', 'dev1');

    /* load modx */
    require_once dirname(dirname(__FILE__)) . '/config.core.php';
    require_once MODX_CORE_PATH . 'model/modx/modx.class.php';
    $modx = new modX();
    $modx->initialize('mgr');
    $modx->setLogLevel(modX::LOG_LEVEL_INFO);
    $modx->setLogTarget('ECHO');


    echo '<pre>';
    flush();
    $targetDirectory = dirname(dirname(__FILE__)) . '/_packages/';
}
else {
    $targetDirectory = MOREPROVIDER_BUILD_TARGET;
}

$root = dirname(dirname(__FILE__)).'/';
$sources = [
    'root' => $root,
    'build' => $root . '_build/',
    'events' => $root . '_build/events/',
    'validators' => $root . '_build/validators/',
    'resolvers' => $root . '_build/resolvers/',
    'data' => $root . '_build/data/',
    'source_core' => $root . 'core/components/' . PKG_NAMESPACE,
    'source_assets' => $root . 'assets/components/' . PKG_NAMESPACE,
    'plugins' => $root . 'core/components/' . PKG_NAMESPACE . '/elements/plugins/',
    'snippets' => $root . 'core/components/' . PKG_NAMESPACE . '/elements/snippets/',
    'lexicon' => $root . 'core/components/' . PKG_NAMESPACE . '/lexicon/',
    'docs' => $root . 'core/components/' . PKG_NAMESPACE . '/docs/',
    'model' => $root . 'core/components/' . PKG_NAMESPACE . '/model/',
];
unset($root);

require_once $sources['root'] . 'config.core.php';
require_once MODX_CORE_PATH . 'model/modx/modx.class.php';

$modx= new modX();
$modx->initialize('mgr');
$modx->setLogLevel(modX::LOG_LEVEL_INFO);
$modx->setLogTarget('ECHO');

$modx->loadClass('transport.modPackageBuilder', '', false, true);
$builder = new modPackageBuilder($modx);
$builder->directory = $targetDirectory;
$builder->createPackage(PKG_NAMESPACE, PKG_VERSION, PKG_RELEASE);
$builder->registerNamespace(
    PKG_NAMESPACE,
    false,
    true,
    '{core_path}components/' . PKG_NAMESPACE . '/',
    '{assets_path}components/' . PKG_NAMESPACE . '/',
);
$modx->getService('lexicon', 'modLexicon');


$builder->package->put(
    [
        'source' => $sources['source_core'],
        'target' => "return MODX_CORE_PATH . 'components/';",
    ],
    [
        xPDOTransport::ABORT_INSTALL_ON_VEHICLE_FAIL => true,
        'vehicle_class' => 'xPDOFileVehicle',
        'validate' => [
            [
                'type' => 'php',
                'source' => $sources['validators'] . 'requirements.script.php'
            ],
        ],
    ],
);
$builder->package->put(
    [
        'source' => $sources['source_assets'],
        'target' => "return MODX_ASSETS_PATH . 'components/';",
    ],
    [
        'vehicle_class' => 'xPDOFileVehicle',
    ],
);
$modx->log(modX::LOG_LEVEL_INFO,'Packaged in files.');
flush();

// Category
$category= $modx->newObject('modCategory');
$category->set('id', 1);
$category->set('category', PKG_NAME);
$modx->log(modX::LOG_LEVEL_INFO,'Packaged in category.');
flush();

// Settings
$settings = include_once $sources['data'].'transport.settings.php';
$attributes= [
    xPDOTransport::UNIQUE_KEY => 'key',
    xPDOTransport::PRESERVE_KEYS => true,
    xPDOTransport::UPDATE_OBJECT => false,
];
if (!is_array($settings)) {
    $modx->log(modX::LOG_LEVEL_FATAL,'Adding settings failed.');
}
foreach ($settings as $setting) {
    $vehicle = $builder->createVehicle($setting,$attributes);
    $builder->putVehicle($vehicle);
}
$modx->log(modX::LOG_LEVEL_INFO,'Packaged in '.count($settings).' system settings.');
flush();
unset($settings,$setting,$attributes);

// Plugins
$plugins = include $sources['data'] . 'transport.plugins.php';
if (!is_array($plugins)) {
    $modx->log(modX::LOG_LEVEL_FATAL,'Adding plugins failed.');
}
$attributes= [
    xPDOTransport::UNIQUE_KEY => 'name',
    xPDOTransport::PRESERVE_KEYS => false,
    xPDOTransport::UPDATE_OBJECT => true,
    xPDOTransport::RELATED_OBJECTS => true,
    xPDOTransport::RELATED_OBJECT_ATTRIBUTES => [
        'PluginEvents' => [
            xPDOTransport::PRESERVE_KEYS => true,
            xPDOTransport::UPDATE_OBJECT => false,
            xPDOTransport::UNIQUE_KEY => ['pluginid', 'event'],
        ],
    ],
];
foreach ($plugins as $plugin) {
    $vehicle = $builder->createVehicle($plugin, $attributes);
    $builder->putVehicle($vehicle);
}
$modx->log(modX::LOG_LEVEL_INFO,'Packaged in ' . count($plugins) . ' plugins.');
flush();
unset($plugins, $plugin, $attributes);

// Menus
require_once ($sources['data'] . 'transport.menus.php');
$modx->log(modX::LOG_LEVEL_INFO,'Packaged in menus');

// Category Vehicle
$attr = [
    xPDOTransport::UNIQUE_KEY => 'category',
    xPDOTransport::PRESERVE_KEYS => false,
    xPDOTransport::UPDATE_OBJECT => true,
    xPDOTransport::RELATED_OBJECTS => false,
];
$vehicle = $builder->createVehicle($category, $attr);
$vehicle->resolve('php', [
    'source' => $sources['resolvers'] . 'composer.resolver.php',
]);
$vehicle->resolve('php', [
    'source' => $sources['resolvers'] . 'tables.resolver.php',
]);
$vehicle->resolve('php', [
    'source' => $sources['resolvers'] . 'setupoptions.resolver.php',
]);
//$vehicle->resolve('php', [
//    'source' => $sources['resolvers'] . 'dashboardwidgets.resolver.php',
//]);
//$vehicle->resolve('php', [
//    'source' => $sources['resolvers'] . 'cleanup.resolver.php',
//]);

$modx->log(modX::LOG_LEVEL_INFO,'Packaged in resolvers.');
flush();
$builder->putVehicle($vehicle);

// Now pack in the license file, readme and setup options
$builder->setPackageAttributes([
    'license' => file_get_contents($sources['docs'] . 'license.txt'),
    'readme' => file_get_contents($sources['docs'] . 'readme.txt'),
    'changelog' => file_get_contents($sources['docs'] . 'changelog.txt'),
    'setup-options' => [
        'source' => $sources['build'].'setup.options.php',
    ],
]);
$modx->log(modX::LOG_LEVEL_INFO,'Packaged in package attributes.');
flush();

$modx->log(modX::LOG_LEVEL_INFO,'Packing...');
flush();
$builder->pack();

$mtime = microtime();
$mtime = explode(" ", $mtime);
$mtime = $mtime[1] + $mtime[0];
$tend = $mtime;
$totalTime = ($tend - $tstart);
$totalTime = sprintf("%2.4f s", $totalTime);

$modx->log(modX::LOG_LEVEL_INFO,"\n<br />Package Built.<br />\nExecution time: {$totalTime}\n");

/**
 * @param string $filename
 * @return string
 */
function getSnippetContent(string $filename = ''): string
{
    $o = file_get_contents($filename);
    $o = str_replace('<?php', '', $o);
    $o = str_replace('?>', '', $o);
    return trim($o);
}