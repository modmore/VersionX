<?php

use modmore\VersionX\Types\Chunk;
use modmore\VersionX\Types\Plugin;
use modmore\VersionX\Types\Resource;
use modmore\VersionX\Types\Snippet;
use modmore\VersionX\Types\Template;
use modmore\VersionX\Types\TV;
use modmore\VersionX\Types\Type;

if (isset($object) && isset($object->xpdo)) {
    $modx = $object->xpdo;
}
if (!isset($modx)) {
    require_once dirname(dirname(dirname(__DIR__))) . '/config.core.php';
    require_once MODX_CORE_PATH . 'model/modx/modx.class.php';

    $modx = new modX();
    $modx->initialize('web');
    $modx->setLogLevel(modX::LOG_LEVEL_INFO);
    $modx->setLogTarget('ECHO');
    $modx->loadClass('transport.xPDOTransport', '', true, true);
    $options = [
        'vx_snapshot_resources' => true,
        'vx_snapshot_templates' => true,
        'vx_snapshot_chunks' => true,
        'vx_snapshot_snippets' => true,
        'vx_snapshot_plugins' => true,
        'vx_snapshot_tmplvars' => true,
    ];
}

switch ($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_UPGRADE:
    case xPDOTransport::ACTION_INSTALL:
        @set_time_limit(0);

        /* @var VersionX $versionX */
        $corePath = $modx->getOption('versionx.core_path',null,$modx->getOption('core_path').'components/versionx/');
        $versionX = $modx->getService('versionx','VersionX',$corePath . '/model/');

        $modx->log(modX::LOG_LEVEL_INFO,'Starting snapshot process for selected objects...');

        if (isset($options['vx_snapshot_resources']) && !empty($options['vx_snapshot_resources'])) {
            createInitialDelta(modResource::class, new Resource($versionX), 'Resource');
        }

        if (isset($options['vx_snapshot_templates']) && !empty($options['vx_snapshot_templates'])) {
            createInitialDelta(modTemplate::class, new Template($versionX), 'Template');
        }

        if (isset($options['vx_snapshot_chunks']) && !empty($options['vx_snapshot_chunks'])) {
            createInitialDelta(modChunk::class, new Chunk($versionX), 'Chunk');
        }

        if (isset($options['vx_snapshot_snippets']) && !empty($options['vx_snapshot_snippets'])) {
            createInitialDelta(modSnippet::class, new Snippet($versionX), 'Snippet');
        }

        if (isset($options['vx_snapshot_plugins']) && !empty($options['vx_snapshot_plugins'])) {
            createInitialDelta(modPlugin::class, new Plugin($versionX),'Plugin');
        }

        if (isset($options['vx_snapshot_tmplvars']) && !empty($options['vx_snapshot_tmplvars'])) {
            createInitialDelta(modTemplateVar::class, new TV($versionX), 'TV');
        }

    break;
}

/**
 * @param string $class
 * @param Type $type
 * @param string $name
 * @return void
 */
function createInitialDelta(string $class, Type $type, string $name): void
{
    global $modx, $versionX;

    $modx->log(modX::LOG_LEVEL_INFO,"Iterating over {$name}s and storing snapshots..");

    $count = 0;
    foreach ($modx->getIterator($class) as $object) {
        if ($versionX->deltas()->createDelta($object->get('id'), $type)) {
            $count++;
        }
        else {
            $modx->log(modX::LOG_LEVEL_WARN,"Error creating snapshot for {$name} {$object->get('id')}");
        }

        if (is_int($count / 25)) {
            $modx->log(modX::LOG_LEVEL_INFO,"Checked {$count} {$name}s so far.");
        }
    }

    $modx->log(modX::LOG_LEVEL_WARN,"Iterated over {$count} {$name}s.");
}
    
return true;
