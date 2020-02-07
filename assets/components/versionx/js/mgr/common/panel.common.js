Ext.ns('VersionX.panel.Common');
VersionX.panel.Common.DetailPanel = function(config) {
    config = config || {};
    Ext.apply(config,{
        items: [{
            layout: 'column',
            border: false,
            items: [
                {
                    xtype: (typeof config.vxGridXType != 'undefined') ? config.vxGridXType : 'versionx-grid-common-detailgrid',
                    vxRecord: config.vxRecord,
                    vxRecordCmp: config.vxRecordCmp ? config.vxRecordCmp : undefined,
                    vxFieldMap: config.vxFieldMap
                }
            ]
        }]
    });
    VersionX.panel.Common.DetailPanel.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.panel.Common.DetailPanel,MODx.Panel,{});
Ext.reg('versionx-panel-common-detailpanel',VersionX.panel.Common.DetailPanel);

VersionX.panel.Common.NotFound = function(config) {
    config = config || {};
    Ext.apply(config,{
        items: [{
            xtype: 'panel',
            html: '<div class="vx-error-panel"><p>The requested version does not exist.</p></div>'
        }]
    });
    VersionX.panel.Common.NotFound.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.panel.Common.NotFound,MODx.Panel,{});
Ext.reg('versionx-panel-notfound',VersionX.panel.Common.NotFound);
