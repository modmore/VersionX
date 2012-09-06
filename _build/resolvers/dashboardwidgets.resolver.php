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

        $featureTest = $modx->loadClass('modDashboardWidget');
        if (!$featureTest) {
            $modx->log(modX::LOG_LEVEL_WARN,'VersionX includes a dashboard widget for MODX 2.2, unfortunately you seem to be running a MODX version that does not support dashboard widgets. To use the widget, please update your MODX installation and re-install the VersionX package.');
            return true;
        }

        $widget = $modx->getObject('modDashboardWidget',array('name' => 'versionx.widget.resources'));
        if (!$widget) {
            $widget = $modx->newObject('modDashboardWidget');
            $widget->fromArray(array (
              'name' => 'versionx.widget.resources',
              'description' => 'versionx.widget.resources.desc',
              'type' => 'file',
              'size' => 'half',
              'content' => '[[++core_path]]components/versionx/elements/widgets/resources.dashboardwidget.php',
              'namespace' => 'versionx',
              'lexicon' => 'versionx:default',
            ), '', true, true);
            if (!$widget->save()) {
                $modx->log(modX::LOG_LEVEL_ERROR,'Error creating the VersionX Resources dashboard widget.');
            } else {
                $modx->log(modX::LOG_LEVEL_INFO,'Added VersionX Resources dashboard widget to your MODX installation. To use it, add it to a dashboard.');
            }
        } else {
            $modx->log(modX::LOG_LEVEL_INFO, 'VersionX Resources dashboard widgets is already installed.');
        }

        break;
    case xPDOTransport::ACTION_UNINSTALL:
        $widget = $modx->getObject('modDashboardWidget',array('name' => 'versionx.widget.resources'));
        if ($widget) {
            if ($widget->remove())
                $modx->log(modX::LOG_LEVEL_WARN,'Removed VersionX Dashboard Widget.');
            else
                $modx->log(modX::LOG_LEVEL_ERROR, 'Error removing VersionX Dashboard Widget.');
        }
        break;
}



return true;
