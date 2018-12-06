<?php

if (isset($object) && isset($object->xpdo)) {
    $modx = $object->xpdo;
}
if (!isset($modx)) {
    require_once dirname(dirname(dirname(__DIR__))) . '/config.core.php';
    require_once MODX_CORE_PATH . 'model/modx/modx.class.php';
    $modx= new modX();
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

        /* @var VersionX $versionx */
        $corePath = $modx->getOption('versionx.core_path',null,$modx->getOption('core_path').'components/versionx/');
        $versionx =& $modx->getService('versionx','VersionX',$corePath.'/model/');

        $modx->log(modX::LOG_LEVEL_INFO,'Starting snapshot process for selected objects...');
        /* If we wanted resources snapshot, make that */
        if (isset($options['vx_snapshot_resources']) && !empty($options['vx_snapshot_resources'])) {
            $modx->log(modX::LOG_LEVEL_INFO,'Iterating over Resources and storing snapshots..');
            $count = 0;
            foreach ($modx->getIterator('modResource') as $object) {
                if ($versionx->newResourceVersion($object, 'snapshot')) { $count++; }
                else { $modx->log(modX::LOG_LEVEL_WARN,'Error creating snapshot for Resource '.$object->get('id')); }

                if (is_int($count / 25)) { $modx->log(modX::LOG_LEVEL_INFO,"Checked {$count} Resources so far."); }
            }
            $modx->log(modX::LOG_LEVEL_WARN,'Iterated over '.$count.' Resources.');
        }

        /* If we wanted template snapshot, make that */
        if (isset($options['vx_snapshot_templates']) && !empty($options['vx_snapshot_templates'])) {
            $modx->log(modX::LOG_LEVEL_INFO,'Iterating over Templates and storing snapshots..');
            $count = 0;
            foreach ($modx->getIterator('modTemplate') as $object) {
                if ($versionx->newTemplateVersion($object, 'snapshot')) { $count++; }
                else { $modx->log(modX::LOG_LEVEL_WARN,'Error creating snapshot for Template '.$object->get('id')); }

                if (is_int($count / 10)) { $modx->log(modX::LOG_LEVEL_INFO,"Checked {$count} Templates so far."); }
            }
            $modx->log(modX::LOG_LEVEL_WARN,'Iterated over  '.$count.' Templates.');
        }

        /* If we wanted chunk snapshot, make that */
        if (isset($options['vx_snapshot_chunks']) && !empty($options['vx_snapshot_chunks'])) {
            $modx->log(modX::LOG_LEVEL_INFO,'Iterating over Chunks and storing snapshots..');
            $count = 0;
            foreach ($modx->getIterator('modChunk') as $object) {
                if ($versionx->newChunkVersion($object, 'snapshot')) { $count++; }
                else { $modx->log(modX::LOG_LEVEL_WARN,'Error creating snapshot for Chunk '.$object->get('id')); }

                if (is_int($count / 25)) { $modx->log(modX::LOG_LEVEL_INFO,"Checked {$count} Chunks so far."); }
            }
            $modx->log(modX::LOG_LEVEL_WARN,'Iterated over '.$count.' Chunks.');
        }

        /* If we wanted snippet snapshot, make that */
        if (isset($options['vx_snapshot_snippets']) && !empty($options['vx_snapshot_snippets'])) {
            $modx->log(modX::LOG_LEVEL_INFO,'Iterating over Snippets and storing snapshots..');
            $count = 0;
            foreach ($modx->getIterator('modSnippet') as $object) {
                if ($versionx->newSnippetVersion($object, 'snapshot')) { $count++; }
                else { $modx->log(modX::LOG_LEVEL_WARN,'Error creating snapshot for Snippet '.$object->get('id')); }

                if (is_int($count / 10)) { $modx->log(modX::LOG_LEVEL_INFO,"Checked {$count} Snippets so far."); }
            }
            $modx->log(modX::LOG_LEVEL_WARN,'Iterated over '.$count.' Snippets.');
        }

        /* If we wanted plugins snapshot, make that */
        if (isset($options['vx_snapshot_plugins']) && !empty($options['vx_snapshot_plugins'])) {
            $modx->log(modX::LOG_LEVEL_INFO,'Iterating over Plugins and storing snapshots..');
            $count = 0;
            foreach ($modx->getIterator('modPlugin') as $object) {
                if ($versionx->newPluginVersion($object, 'snapshot')) { $count++; }
                else { $modx->log(modX::LOG_LEVEL_WARN,'Error creating snapshot for Plugin '.$object->get('id')); }

                if (is_int($count / 10)) { $modx->log(modX::LOG_LEVEL_INFO,"Checked {$count} Plugins so far."); }
            }
            $modx->log(modX::LOG_LEVEL_WARN,'Iterated over '.$count.' Plugins.');
        }

        /* If we wanted tv snapshot, make that */
        if (isset($options['vx_snapshot_tmplvars']) && !empty($options['vx_snapshot_tmplvars'])) {
            $modx->log(modX::LOG_LEVEL_INFO,'Iterating over Template Variables and storing snapshots..');
            $count = 0;
            foreach ($modx->getIterator('modTemplateVar') as $object) {
                if ($versionx->newTemplateVarVersion($object, 'snapshot')) { $count++; }
                else { $modx->log(modX::LOG_LEVEL_WARN,'Error creating snapshot for Template Variable '.$object->get('id')); }

                if (is_int($count / 10)) { $modx->log(modX::LOG_LEVEL_INFO,"Checked {$count} Template Variables so far."); }
            }
            $modx->log(modX::LOG_LEVEL_WARN,'Iterated over '.$count.' Template Variables.');
        }
    break;
}
    
    
return true;
