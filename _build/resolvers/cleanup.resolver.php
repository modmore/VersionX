<?php

if ($object->xpdo) {
    switch ($options[xPDOTransport::PACKAGE_ACTION]) {
        case xPDOTransport::ACTION_INSTALL:
        case xPDOTransport::ACTION_UPGRADE:
            $files = [
                MODX_CORE_PATH . 'components/versionx/processors/mgr/chunks/get_versions.php',
                MODX_CORE_PATH . 'components/versionx/processors/mgr/chunks/getlist.php',
                MODX_CORE_PATH . 'components/versionx/processors/mgr/chunks/revert.php',
                MODX_CORE_PATH . 'components/versionx/processors/mgr/plugins/get_versions.php',
                MODX_CORE_PATH . 'components/versionx/processors/mgr/plugins/getlist.php',
                MODX_CORE_PATH . 'components/versionx/processors/mgr/plugins/revert.php',
                MODX_CORE_PATH . 'components/versionx/processors/mgr/resources/get_versions.php',
                MODX_CORE_PATH . 'components/versionx/processors/mgr/resources/getlist.php',
                MODX_CORE_PATH . 'components/versionx/processors/mgr/resources/revert.php',
                MODX_CORE_PATH . 'components/versionx/processors/mgr/snippets/get_versions.php',
                MODX_CORE_PATH . 'components/versionx/processors/mgr/snippets/getlist.php',
                MODX_CORE_PATH . 'components/versionx/processors/mgr/snippets/revert.php',
                MODX_CORE_PATH . 'components/versionx/processors/mgr/templates/get_versions.php',
                MODX_CORE_PATH . 'components/versionx/processors/mgr/templates/getlist.php',
                MODX_CORE_PATH . 'components/versionx/processors/mgr/templates/revert.php',
                MODX_CORE_PATH . 'components/versionx/processors/mgr/templatevars/get_versions.php',
                MODX_CORE_PATH . 'components/versionx/processors/mgr/templatevars/getlist.php',
                MODX_CORE_PATH . 'components/versionx/processors/mgr/templatevars/revert.php',
            ];

            foreach ($files as $file) {
                if (file_exists($file)) {
                    is_dir($file) ? rmdir($file) : unlink($file);
                }
            }

            break;
        case xPDOTransport::ACTION_UNINSTALL:
            break;
    }
}
return true;
