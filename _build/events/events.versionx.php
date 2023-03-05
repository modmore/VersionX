<?php

$events = [];

$e = [
    'OnMODXInit',
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

    'FredOnFredResourceSave',
];

foreach ($e as $ev) {
    /** @var \modX|\MODX\Revolution\modX $modx */
    $events[$ev] = $modx->newObject('modPluginEvent');
    $events[$ev]->fromArray([
        'event' => $ev,
        // Lower priority to make sure other plugins do their processing first.
        'priority' => 10,
        'propertyset' => 0
    ],'',true,true);
}

return $events;


