<?php

/**
 * @var \modX|\MODX\Revolution\modX $modx
 * @var \xPDOTransport|\xPDO\Transport\xPDOTransport $object
 * @var array $options
 */
if ($object->xpdo) {
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_UPGRADE:
        case xPDOTransport::ACTION_INSTALL:
            $modx = $object->xpdo;

            $modelPath = $modx->getOption(
                'versionx.core_path',
                null,
                $modx->getOption('core_path') . 'components/versionx/'
                ) . 'model/';

            $modx->addPackage('versionx', $modelPath);
            $manager = $modx->getManager();
            $loglevel = $modx->setLogLevel(modx::LOG_LEVEL_ERROR);

            $objects = [
                'vxDelta',
                'vxDeltaField',
                'vxDeltaEditor',
            ];
            foreach ($objects as $obj) {
                $manager->createObjectContainer($obj);
            }

            // Set to fatal errors only while updating database, to avoid false positives displayed.
            $modx->setLogLevel(modX::LOG_LEVEL_FATAL);

            // VersionX 3.1.3
            // These fields are added to keep track of data types to be used when reverting
            $manager->addField('vxDeltaField', 'before_type', ['after' => 'field_type']);
            $manager->addField('vxDeltaField', 'after_type', ['after' => 'before_type']);

            // VersionX 3.3.0
            // Remove explicit CURRENT_TIMESTAMP default on datetime fields for compatibility with MariaDB
            $manager->alterField('vxDelta', 'time_start');
            $manager->alterField('vxDelta', 'time_end');

            $modx->setLogLevel($loglevel);

        break;
    }

}
return true;

