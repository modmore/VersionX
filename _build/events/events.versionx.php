<?php

$events = array();

$e = array(
    'OnBeforeDocFormSave',
    'OnDocFormSave',
    'OnTempFormSave',
    'OnTVFormSave',
    'OnChunkFormSave',
    'OnSnipFormSave',
    'OnPluginFormSave',

    'OnDocFormPrerender',
    'OnDocFormRender',
    'OnTempFormPrerender',
    'OnTVFormPrerender',
    'OnChunkFormPrerender',
    'OnSnipFormPrerender',
    'OnPluginFormPrerender',
);

foreach ($e as $ev) {
    $events[$ev] = $modx->newObject('modPluginEvent');
    $events[$ev]->fromArray(array(
        'event' => $ev,
        'priority' => 0,
        'propertyset' => 0
    ),'',true,true);
}

return $events;


