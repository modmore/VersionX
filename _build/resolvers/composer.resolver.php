<?php

/**
 * @var modX $modx
 * @var array $options
 * @var xPDOTransport $transport
 */

use Composer\Console\HtmlOutputFormatter;
use Composer\Factory;
use Composer\Installer;
use Composer\IO\BufferIO;
use Symfony\Component\Console\Output\StreamOutput;

if (!$transport->xpdo) {
    return false;
}

$modx = $transport->xpdo;

// Only run on install and upgrade
if (!in_array($options[xPDOTransport::PACKAGE_ACTION], [xPDOTransport::ACTION_INSTALL, xPDOTransport::ACTION_UPGRADE], true)) {
    return true;
}

$modx->log(modX::LOG_LEVEL_INFO, 'Installing/updating dependencies, this may take some time...');

$path = MODX_CORE_PATH . 'components/versionx/';
// Tell composer where to look
putenv("COMPOSER={$path}composer.json");
putenv("COMPOSER_HOME={$path}.composer");
putenv("COMPOSER_VENDOR_DIR={$path}vendor/");
// And make PHP think we're in a different path too, to prevent autoloading namespaces relative to where composer is executed breaking
chdir($path);

require "phar://{$path}composer.phar/vendor/autoload.php";

$io = new BufferIO('', StreamOutput::VERBOSITY_NORMAL, new HtmlOutputFormatter());
$composer = Factory::create($io);
$install = Installer::create($io, $composer);
$install
    ->setPreferDist(true)
    ->setDevMode(false)
    ->setOptimizeAutoloader(true)
    ->setUpdate(false)
    ->setPreferStable(true);

$success = true;
try {
    $install->run();
} catch (Exception $e) {
    $success = false;
    $modx->log(modX::LOG_LEVEL_ERROR, get_class($e) . ' installing dependencies: ' . $e->getMessage());
    echo get_class($e) . ': ' . $e->getMessage() . "\n";
}

$output = $io->getOutput();
$output = nl2br(trim($output));
$modx->log(modX::LOG_LEVEL_INFO, $output);

return $success;
