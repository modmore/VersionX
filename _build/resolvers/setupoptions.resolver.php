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

switch ($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_UPGRADE:
    case xPDOTransport::ACTION_INSTALL:
        @set_time_limit(0);

        /* @var VersionX $versionx */
        $corePath = $modx->getOption('versionx.core_path',null,$modx->getOption('core_path').'components/versionx/');
        $versionx = $modx->getService('versionx','VersionX',$corePath.'/model/');
        $versionx->initialize('mgr');

        $modx->log(modX::LOG_LEVEL_INFO,'Starting snapshot process for selected objects...');
        /* If we wanted resources snapshot, make that */
        if (isset($options['vx_snapshot_resources']) && !empty($options['vx_snapshot_resources'])) {
            $collection = $modx->getCollection('modResource');
            $modx->log(modX::LOG_LEVEL_INFO,'Resources loaded. Iterating over resources and storing snapshots..');
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
            $modx->log(modX::LOG_LEVEL_WARN,'Checked '.$count.' resources and stored snapshots where needed.');
        }

        /* If we wanted template snapshot, make that */
        if (isset($options['vx_snapshot_templates']) && !empty($options['vx_snapshot_templates'])) {
            $collection = $modx->getCollection('modTemplate');
            $modx->log(modX::LOG_LEVEL_INFO,'Templates loaded. Iterating over templates and storing snapshots..');
            $count = 0;
            foreach ($collection as $object) {
                if ($versionx->newTemplateVersion($object, 'snapshot')) { $count++; }
                else { $modx->log(modX::LOG_LEVEL_WARN,'Error creating snapshot for template '.$object->get('id')); }

                if (is_int($count / 10)) { $modx->log(modX::LOG_LEVEL_INFO,"Checked {$count} templates so far."); }
            }
            $modx->log(modX::LOG_LEVEL_WARN,'Checked '.$count.' Templates and stored snapshots where needed.');
        }

        /* If we wanted chunk snapshot, make that */
        if (isset($options['vx_snapshot_chunks']) && !empty($options['vx_snapshot_chunks'])) {
            $collection = $modx->getCollection('modChunk');
            $modx->log(modX::LOG_LEVEL_INFO,'Chunks loaded. Iterating over chunks and storing snapshots..');
            $count = 0;
            foreach ($collection as $object) {
                if ($versionx->newChunkVersion($object, 'snapshot')) { $count++; }
                else { $modx->log(modX::LOG_LEVEL_WARN,'Error creating snapshot for chunk '.$object->get('id')); }

                if (is_int($count / 25)) { $modx->log(modX::LOG_LEVEL_INFO,"Checked {$count} chunks so far."); }
            }
            $modx->log(modX::LOG_LEVEL_WARN,'Checked '.$count.' Chunks and stored snapshots where needed.');
        }

        /* If we wanted snippet snapshot, make that */
        if (isset($options['vx_snapshot_snippets']) && !empty($options['vx_snapshot_snippets'])) {
            $collection = $modx->getCollection('modSnippet');
            $modx->log(modX::LOG_LEVEL_INFO,'Snippets loaded. Iterating over snippets and storing snapshots..');
            $count = 0;
            foreach ($collection as $object) {
                if ($versionx->newSnippetVersion($object, 'snapshot')) { $count++; }
                else { $modx->log(modX::LOG_LEVEL_WARN,'Error creating snapshot for Snippet '.$object->get('id')); }

                if (is_int($count / 10)) { $modx->log(modX::LOG_LEVEL_INFO,"Checked {$count} snippets so far."); }
            }
            $modx->log(modX::LOG_LEVEL_WARN,'Checked '.$count.' Snippets and stored snapshots where needed.');
        }

        /* If we wanted plugins snapshot, make that */
        if (isset($options['vx_snapshot_plugins']) && !empty($options['vx_snapshot_plugins'])) {
            $collection = $modx->getCollection('modPlugin');
            $modx->log(modX::LOG_LEVEL_INFO,'Plugins loaded. Iterating over Plugins and storing snapshots..');
            $count = 0;
            foreach ($collection as $object) {
                if ($versionx->newPluginVersion($object, 'snapshot')) { $count++; }
                else { $modx->log(modX::LOG_LEVEL_WARN,'Error creating snapshot for Plugin '.$object->get('id')); }

                if (is_int($count / 10)) { $modx->log(modX::LOG_LEVEL_INFO,"Checked {$count} Plugins so far."); }
            }
            $modx->log(modX::LOG_LEVEL_WARN,'Checked '.$count.' Plugins and stored snapshots where needed.');
        }

        /* If we wanted tv snapshot, make that */
        if (isset($options['vx_snapshot_tmplvars']) && !empty($options['vx_snapshot_tmplvars'])) {
            $collection = $modx->getCollection('modTemplateVar');
            $modx->log(modX::LOG_LEVEL_INFO,'Template Variables loaded. Iterating over Template Variables and storing snapshots..');
            $count = 0;
            foreach ($collection as $object) {
                if ($versionx->newTemplateVarVersion($object, 'snapshot')) { $count++; }
                else { $modx->log(modX::LOG_LEVEL_WARN,'Error creating snapshot for Template Variable '.$object->get('id')); }

                if (is_int($count / 10)) { $modx->log(modX::LOG_LEVEL_INFO,"Checked {$count} Template Variables so far."); }
            }
            $modx->log(modX::LOG_LEVEL_WARN,'Checked '.$count.' Template Variables and stored snapshots where needed.');
        }

    break;
}
    
    
return true;
