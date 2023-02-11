<?php
/**
 * @var modX $modx
 */
$s = include __DIR__ . '/settings.php';

$settings = array();

foreach ($s as $key => $value) {
    if (is_string($value) || is_int($value)) { $type = 'textfield'; }
    elseif (is_bool($value)) { $type = 'combo-boolean'; }
    else { $type = 'textfield'; }

    $area = $value['area'];

    $settings['versionx.'.$key] = $modx->newObject('modSystemSetting');
    $settings['versionx.'.$key]->set('key', 'versionx.' . $key);
    $settings['versionx.'.$key]->fromArray([
        'value' => $value,
        'xtype' => $type,
        'namespace' => 'versionx',
        'area' => $area
    ]);
}

return $settings;


