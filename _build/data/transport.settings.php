<?php

$s = array(
    'debug' => false,
    'formtabs.resource' => true,
    'formtabs.template' => true,
    'formtabs.templatevariables' => true,

    'enable.resources' => true,
    'enable.templates' => true,
    'enable.templatevariables' => true,
    'enable.chunks' => true,
    'enable.snippets' => true,
    'enable.plugins' => true,
);

$settings = array();

foreach ($s as $key => $value) {
    if (is_string($value) || is_int($value)) { $type = 'textfield'; }
    elseif (is_bool($value)) { $type = 'combo-boolean'; }
    else { $type = 'textfield'; }

    $parts = explode('.',$key);
    if (count($parts) == 1) { $area = 'Default'; }
    else { $area = $parts[0]; }
    
    $settings['versionx.'.$key] = $modx->newObject('modSystemSetting');
    $settings['versionx.'.$key]->set('key', 'versionx.'.$key);
    $settings['versionx.'.$key]->fromArray(array(
        'value' => $value,
        'xtype' => $type,
        'namespace' => 'versionx',
        'area' => $area
    ));
}

return $settings;


