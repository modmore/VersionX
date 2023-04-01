<?php

use modmore\VersionX\Utils;
use modmore\VersionX\VersionX;
use MODX\Revolution\modX;

require_once dirname(__DIR__, 3) . '/config.core.php';
require_once MODX_CORE_PATH . 'config/' . MODX_CONFIG_KEY . '.inc.php';
require_once MODX_CONNECTORS_PATH . 'index.php';

const CLASSES = [
    vxResource::class => 'modResource',
    vxTemplate::class => 'modTemplate',
    vxChunk::class => 'modChunk',
    vxSnippet::class => 'modSnippet',
    vxPlugin::class => 'modPlugin',
    vxTemplateVar::class => 'modTemplateVar',
];

// Keep track of completed migrations. Handy for quickly grabbing the last one.
$completed = [];

/** @var \modX|modX $modx */
$versionX = new VersionX($modx);

foreach (CLASSES as $vxClass => $principalClass) {
    $vxObjects = query($vxClass);
    foreach ($vxObjects as $vxObject) {
        // Ensure the principal object exists before migrating
        if ($modx->getObject($principalClass, $vxObject->get('content_id'))) {
            createDelta($vxObject);
        }

    }

    // todo: remove!
    break;
}

function query(string $class): xPDOIterator
{
    global $modx;
    $c = $modx->newQuery($class);

    // Sorting by principal object, oldest to newest
    // This is important so we can more easily populate before/after fields
    $c->sortby('content_id');
    $c->sortby('saved');
    return $modx->getIterator($class, $c);
}

function createDelta($object)
{
    global $modx;
    global $completed;

    $delta = $modx->newObject(vxDelta::class, [
        'principal_package' => 'core',
        'principal_class' => 'modResource',
        'principal' => $object->get('content_id'),
        'time_start' => $object->get('saved'),
        'time_end' => $object->get('saved'),
    ]);

    switch (get_class($object)) {
        // Resources
        case vxResource_mysql::class:
            $delta->set('type_class', 'modmore\VersionX\Types\Resource');
            $delta->save();

            $items = mergeTVs($object);

            $prevItems = [];
            // Check for a previous version for this principal object. If so, use the contents for the "before" fields
            if (isset($completed[get_class($object) . '_' . $object->get('content_id')])) {
                $prevVersion = $completed[get_class($object) . '_' . $object->get('content_id')];
                $prevItems = mergeTVs($prevVersion);
            }

            createFields($delta, $items, $prevItems);
            break;

        // Templates
        case vxTemplate_mysql::class:
            $delta->set('type_class', 'modmore\VersionX\Types\Template');
            $delta->save();
            break;
    }

    $deltaEditor = $modx->newObject(vxDeltaEditor::class, [
        'delta' => $delta->get('id'),
        'user' => $object->get('user'),
    ]);
    $deltaEditor->save();

    // Store as completed
    $completed[get_class($object) . '_' . $object->get('content_id')] = $object;
}

/**
 * @param $delta
 * @param $items
 * @param $prevItems
 * @return void
 */
function createFields($delta, $items, $prevItems)
{
    global $modx;
    global $versionX;
    foreach ($items as $key => $item) {
        $beforeValue = !empty($prevItems) ? Utils::flattenArray($prevItems[$key]) : '';
        $afterValue = Utils::flattenArray($item);
        $diff = $versionX->deltas()::calculateDiff($beforeValue, $afterValue);

        if (!$diff) {
            continue;
        }

        $field = $modx->newObject(vxDeltaField::class, [
            'delta' => $delta->get('id'),
            'field' => $key,
            'type' => 'modmore\VersionX\Fields\Text',
            'before' => $beforeValue,
            'after' => $afterValue,
            'rendered_diff' => $versionX->deltas()::calculateDiff($beforeValue, $afterValue),
        ]);
        $field->save();
    }
}

/**
 * @param $object
 * @return array
 */
function mergeTVs($object): array
{
    global $modx;

    $tvs = [];
    foreach ($object->get('tvs') as $tvContent) {
        $tmpVar = $modx->getObject('modTemplateVar', $tvContent['id']);
        $tvs[$tmpVar->get('name')] = $tvContent['value'];
    }

    return array_merge(
        $object->get('fields'),
        ['content' => $object->get('content')],
        $tvs,
    );
}

@session_write_close();
exit();