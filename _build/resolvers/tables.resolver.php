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

            $modx->setLogLevel($loglevel);

        break;
    }

}
return true;

