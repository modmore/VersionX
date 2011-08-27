<?php

$events = array();

$e = array('OnDocFormSave','OnTempFormSave','OnTVFormSave','OnChunkFormSave','OnSnipFormSave','OnPluginFormSave');

foreach ($e as $ev) {
    $events[$ev] = $modx->newObject('modPluginEvent');
    $events[$ev]->fromArray(array(
        'event' => $ev,
        'priority' => 0,
        'propertyset' => 0
    ),'',true,true);
}

return $events;


?>