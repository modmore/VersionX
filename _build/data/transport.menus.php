<?php

/**
 * @var modMenu $menu
 * @var modX $modx
 * @var modPackageBuilder $builder
 */
$menu = $modx->newObject('modMenu');
$menu->fromArray([
    'text' => 'versionx',
    'description' => 'versionx.menu_desc',
    'parent' => 'components',
    'namespace' => 'versionx',
    'action' => 'index',
], '', true, true);

$vehicle = $builder->createVehicle($menu, [
    xPDOTransport::PRESERVE_KEYS => true,
    xPDOTransport::UPDATE_OBJECT => true,
    xPDOTransport::UNIQUE_KEY => 'text',
]);
$builder->putVehicle($vehicle);
unset($vehicle, $childActions, $action, $menu);