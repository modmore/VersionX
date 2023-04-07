<?php
/**
 * @var modX $modx
 * @var array $options
 */
$settingSource = include __DIR__ . '/settings.php';

$settings = [];

foreach ($settingSource as $key => $options) {
    $val = $options['value'];

    if (isset($options['xtype'])) {
        $xtype = $options['xtype'];
    } elseif (is_int($val)) {
        $xtype = 'numberfield';
    } elseif (is_bool($val)) {
        $xtype = 'modx-combo-boolean';
    } else {
        $xtype = 'textfield';
    }

    $settings[$key] = $modx->newObject('modSystemSetting');
    $settings[$key]->fromArray([
        'key' => 'versionx.' . $key,
        'xtype' => $xtype,
        'value' => $options['value'],
        'namespace' => 'versionx',
        'area' => $options['area'],
        'editedon' => time(),
    ], '', true, true);
}

return $settings;


