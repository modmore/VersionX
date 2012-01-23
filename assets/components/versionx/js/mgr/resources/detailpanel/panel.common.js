VersionX.panel.ResourcesDetail.Common = function(config) {
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
    VersionX.panel.ResourcesDetail.Common.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.panel.ResourcesDetail.Common,MODx.Panel,{});
Ext.reg('versionx-panel-resourcesdetail-common',VersionX.panel.ResourcesDetail.Common);
