<?php
/**
 * @package mhdash
 * @subpackage dashboard
 */
class vxResourceHistoryWidget extends modDashboardWidgetInterface {
    public function render() {
        $corePath = $this->modx->getOption('versionx.core_path',null,$this->modx->getOption('core_path').'components/versionx/');
        require_once $corePath.'model/versionx.class.php';
        $this->modx->versionx = new VersionX($this->modx);
        $this->modx->versionx->initialize('mgr');

        $langs = $this->modx->versionx->_getLangs();
        
        $vxUrl = $this->modx->versionx->config['assets_url'];
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
