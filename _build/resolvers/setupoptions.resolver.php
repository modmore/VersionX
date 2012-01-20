<?php

if (isset($object) && isset($object->xpdo)) {
    $modx = $object->xpdo;
}
if (!isset($modx)) {
    require_once dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/revolution/config.core.php';
    require_once MODX_CORE_PATH . 'model/modx/modx.class.php';
    $modx= new modX();
    $modx->initialize('web');
    $modx->setLogLevel(modX::LOG_LEVEL_INFO);
    $modx->setLogTarget('ECHO');
}

set_time_limit(0);

/* @var VersionX $versionx */
$corePath = $modx->getOption('versionx.core_path',null,$modx->getOption('core_path').'components/versionx/');
$versionx = $modx->getService('versionx','VersionX',$corePath.'/model/');
$versionx->initialize('mgr'); 

/* If we wanted resources snapshot, make that */
if (isset($options['vx_snapshot_resources']) && !empty($options['vx_snapshot_resources'])) {
    $modx->log(modX::LOG_LEVEL_INFO,'Retrieving all resources...');
    $collection = $modx->getCollection('modResource');
    $modx->log(modX::LOG_LEVEL_INFO,'Collection retrieved. Iterating over resources and storing snapshots..');
    $count = 0;
    foreach ($collection as $object) {
        if ($versionx->newResourceVersion($object, 'snapshot')) {
            $count++;
        } else {
            $modx->log(modX::LOG_LEVEL_WARN,'Error creating snapshot for resource '.$object->get('id'));
        }
        if (is_int($count / 25)) {
            $modx->log(modX::LOG_LEVEL_INFO,"Checked {$count} resources so far.");
        }
    }
    $modx->log(modX::LOG_LEVEL_WARN,'Done creating Resource snapshots. A total of '.$count.' resources were checked to confirm a version was stored, and if needed a snapshot was stored.');
}

/* If we wanted template snapshot, make that */
if (isset($options['vx_snapshot_templates']) && !empty($options['vx_snapshot_templates'])) {
    $modx->log(modX::LOG_LEVEL_INFO,'Retrieving all templates...');
    $collection = $modx->getCollection('modTemplate');
    $modx->log(modX::LOG_LEVEL_INFO,'Collection retrieved. Iterating over templates and storing snapshots..');
    $count = 0;
    foreach ($collection as $object) {
        if ($versionx->newTemplateVersion($object, 'snapshot')) { $count++; }
        else { $modx->log(modX::LOG_LEVEL_WARN,'Error creating snapshot for template '.$object->get('id')); }
        
        if (is_int($count / 10)) { $modx->log(modX::LOG_LEVEL_INFO,"Checked {$count} templates so far."); }
    }
    $modx->log(modX::LOG_LEVEL_WARN,'Done creating Template snapshots. A total of '.$count.' templates were checked to confirm a version was stored, and if needed a snapshot was stored.');
}

/* If we wanted chunk snapshot, make that */
if (isset($options['vx_snapshot_chunks']) && !empty($options['vx_snapshot_chunks'])) {
    $modx->log(modX::LOG_LEVEL_INFO,'Retrieving all chunks...');
    $collection = $modx->getCollection('modChunk');
    $modx->log(modX::LOG_LEVEL_INFO,'Collection retrieved. Iterating over chunks and storing snapshots..');
    $count = 0;
    foreach ($collection as $object) {
        if ($versionx->newChunkVersion($object, 'snapshot')) { $count++; }
        else { $modx->log(modX::LOG_LEVEL_WARN,'Error creating snapshot for chunk '.$object->get('id')); }
        
        if (is_int($count / 25)) { $modx->log(modX::LOG_LEVEL_INFO,"Checked {$count} chunks so far."); }
    }
    $modx->log(modX::LOG_LEVEL_WARN,'Done creating Chunk snapshots. A total of '.$count.' chunks were checked to confirm a version was stored, and if needed a snapshot was stored.');
}

/* If we wanted snippet snapshot, make that */
if (isset($options['vx_snapshot_snippets']) && !empty($options['vx_snapshot_snippets'])) {
    $modx->log(modX::LOG_LEVEL_INFO,'Retrieving all Snippets...');
    $collection = $modx->getCollection('modSnippet');
    $modx->log(modX::LOG_LEVEL_INFO,'Collection retrieved. Iterating over snippets and storing snapshots..');
    $count = 0;
    foreach ($collection as $object) {
        if ($versionx->newSnippetVersion($object, 'snapshot')) { $count++; }
        else { $modx->log(modX::LOG_LEVEL_WARN,'Error creating snapshot for Snippet '.$object->get('id')); }
        
        if (is_int($count / 10)) { $modx->log(modX::LOG_LEVEL_INFO,"Checked {$count} snippets so far."); }
    }
    $modx->log(modX::LOG_LEVEL_WARN,'Done creating Snippet snapshots. A total of '.$count.' Snippets were checked to confirm a version was stored, and if needed a snapshot was stored.');
}

/* If we wanted plugins snapshot, make that */
if (isset($options['vx_snapshot_plugins']) && !empty($options['vx_snapshot_plugins'])) {
    $modx->log(modX::LOG_LEVEL_INFO,'Retrieving all Plugins...');
    $collection = $modx->getCollection('modPlugin');
    $modx->log(modX::LOG_LEVEL_INFO,'Collection retrieved. Iterating over Plugins and storing snapshots..');
    $count = 0;
    foreach ($collection as $object) {
        if ($versionx->newPluginVersion($object, 'snapshot')) { $count++; }
        else { $modx->log(modX::LOG_LEVEL_WARN,'Error creating snapshot for Plugin '.$object->get('id')); }
        
        if (is_int($count / 10)) { $modx->log(modX::LOG_LEVEL_INFO,"Checked {$count} Plugins so far."); }
    }
    $modx->log(modX::LOG_LEVEL_WARN,'Done creating Plugin snapshots. A total of '.$count.' Plugins were checked to confirm a version was stored, and if needed a snapshot was stored.');
}

/* If we wanted plugins snapshot, make that */
if (isset($options['vx_snapshot_tmplvars']) && !empty($options['vx_snapshot_tmplvars'])) {
    $modx->log(modX::LOG_LEVEL_INFO,'Retrieving all Template Variables...');
    $collection = $modx->getCollection('modTemplateVar');
    $modx->log(modX::LOG_LEVEL_INFO,'Collection retrieved. Iterating over Template Variables and storing snapshots..');
    $count = 0;
    foreach ($collection as $object) {
        if ($versionx->newTemplateVarVersion($object, 'snapshot')) { $count++; }
        else { $modx->log(modX::LOG_LEVEL_WARN,'Error creating snapshot for Template Variable '.$object->get('id')); }
        
        if (is_int($count / 10)) { $modx->log(modX::LOG_LEVEL_INFO,"Checked {$count} Template Variables so far."); }
    }
    $modx->log(modX::LOG_LEVEL_WARN,'Done creating Template Variable snapshots. A total of '.$count.' Template Variables were checked to confirm a version was stored, and if needed a snapshot was stored.');
}

    
    
return true;
