<?php

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
            createDelta($vxObject, $principalClass);
        }
    }
}

echo "Migration Complete.\n";

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

function createDelta($object, string $principalClass)
{
    global $modx;
    global $completed;

    /** @var vxDelta $delta */
    $delta = $modx->newObject(vxDelta::class, [
        'principal_package' => 'core',
        'principal_class' => $principalClass,
        'principal' => $object->get('content_id'),
        'time_start' => $object->get('saved'),
        'time_end' => $object->get('saved'),
    ]);

    $items = [];
    $prevItems = [];

    // Check for a previous version for this principal object. If so, use the contents for the "before" fields
    if (isset($completed[get_class($object) . '_' . $object->get('content_id')])) {
        $prevVersion = $completed[get_class($object) . '_' . $object->get('content_id')];
    }

    switch (get_class($object)) {
        // Resources
        case vxResource_mysql::class:
            $delta->set('type_class', 'modmore\VersionX\Types\Resource');
            $delta->save();

            $items = mergeTVs($object);
            $prevItems = isset($prevVersion) ? mergeTVs($prevVersion) : [];

            break;

        // Templates
        case vxTemplate_mysql::class:
            $delta->set('type_class', 'modmore\VersionX\Types\Template');
            $delta->save();

            $extraKeys = ['content'];
            $items = getElementFields($object, $extraKeys);
            $prevItems = isset($prevVersion) ? getElementFields($prevVersion, $extraKeys) : [];

            break;

        // Chunks
        case vxChunk_mysql::class:
            $delta->set('type_class', 'modmore\VersionX\Types\Chunk');
            $delta->save();

            $extraKeys = ['snippet'];
            $items = getElementFields($object, $extraKeys);
            $prevItems = isset($prevVersion) ? getElementFields($prevVersion, $extraKeys) : [];

            break;

        // Snippets
        case vxSnippet_mysql::class:
            $delta->set('type_class', 'modmore\VersionX\Types\Snippet');
            $delta->save();

            $extraKeys = ['snippet'];
            $items = getElementFields($object, $extraKeys);
            $prevItems = isset($prevVersion) ? getElementFields($prevVersion, $extraKeys) : [];

            break;

        // Plugins
        case vxPlugin_mysql::class:
            $delta->set('type_class', 'modmore\VersionX\Types\Plugin');
            $delta->save();

            $extraKeys = ['plugincode'];
            $items = getElementFields($object, $extraKeys);
            $prevItems = isset($prevVersion) ? getElementFields($prevVersion, $extraKeys) : [];

            break;

        // TVs
        case vxTemplateVar_mysql::class:
            $delta->set('type_class', 'modmore\VersionX\Types\TV');
            $delta->save();

            $extraKeys = ['type', 'caption', 'rank', 'display', 'default_text', 'input_properties', 'output_properties'];
            $items = getElementFields($object, $extraKeys);
            $prevItems = isset($prevVersion) ? getElementFields($prevVersion, $extraKeys) : [];

            break;
    }

    createFields($delta, $items, $prevItems);

    $deltaEditor = $modx->newObject(vxDeltaEditor::class, [
        'delta' => $delta->get('id'),
        'user' => $object->get('user'),
    ]);
    $deltaEditor->save();

    echo "\033[01;34m*** Delta Editor added => User id {$deltaEditor->get('user')}.\033[0m\n\n";

    // Store as completed
    $completed[get_class($object) . '_' . $object->get('content_id')] = $object;
}

/**
 * @param vxDelta $delta
 * @param array $items
 * @param array $prevItems
 * @return void
 */
function createFields(vxDelta $delta, array $items, array $prevItems)
{
    global $modx;
    global $versionX;

    echo "\033[01;32m{$delta->get('principal_class')} ({$delta->get('principal')}): New delta created ({$delta->get('id')}) => {$delta->get('type_class')}\033[0m\n";
    $echoFields = [];

    foreach ($items as $key => $item) {
        $beforeValue = !empty($prevItems) ? normalizeValue($prevItems[$key]) : '';
        $afterValue = normalizeValue($item);

        $diff = $versionX->deltas()::calculateDiff($beforeValue, $afterValue);

        if (!$diff) {
            continue;
        }

        // Determine the field type
        $typeClass = '\\' . $delta->get('type_class');
        $typeClass = new $typeClass($versionX);

        $field = $modx->newObject(vxDeltaField::class, [
            'delta' => $delta->get('id'),
            'field' => $key,
            'field_type' => $typeClass->getFieldClass($key),
            'before' => $beforeValue,
            'after' => $afterValue,
            'rendered_diff' => $diff,
        ]);
        $field->save();

        $echoFields[] = $key;
    }

    $count = count($echoFields);
    echo "- {$count} field versions migrated: " . implode(',', $echoFields) . "\n";
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

/**
 * @param $object
 * @param array $extraKeys
 * @return array
 */
function getElementFields($object, array $extraKeys): array
{
    $keys = array_merge(['name', 'description', 'category', 'properties'], $extraKeys);

    $fields = [];
    foreach ($keys as $key) {
        $fields[$key] = $object->get($key);
    }

    return $fields;
}

/**
 * @param $value
 * @return mixed|string
 */
function normalizeValue($value)
{
    if ($value === null) {
        return '';
    }

    if (is_array($value) || is_object($value)) {
        return serialize($value);
    }

    return $value;
}

@session_write_close();
exit();