<?php
/**
 * @package versionx
 * @subpackage dashboard
 */
class vxResourceHistoryWidget extends modDashboardWidgetInterface {
    /**
     * Renders the VersionX Resource History widget.
     * @return string
     */
    public function render() {
        /** Load the VersionX class */
        $corePath = $this->modx->getOption('versionx.core_path',null,$this->modx->getOption('core_path').'components/versionx/');
        $versionX = $this->modx->getService('versionx', 'VersionX' , $corePath . 'model/versionx/');
        if (!($versionX instanceof VersionX)) {
            return 'Error loading VersionX class from ' . $corePath;
        }
        $versionX->initialize('mgr');

        $langs = $versionX->_getLangs();
        $vxUrl = $versionX->config['assets_url'];

        $this->modx->regClientStartupHTMLBlock('
            <script type="text/javascript" src="'.$vxUrl.'js/mgr/resources/widget.js" ></script>
            <script type="text/javascript">Ext.onReady(function() {
            '.$langs.'
            MODx.load({
                xtype: "versionx-grid-resources-widget"
                ,renderTo: "versionx-widget-resource-div"
            });
        });</script>');

        return '<div id="versionx-widget-resource-div"></div>';
    }

}
return 'vxResourceHistoryWidget';
