VersionX.panel.ResourcesDetail.Content = function(config) {
    config = config || {};
    Ext.apply(config,{
        id: 'versionx-panel-resourcesdetail-content',
        items: [{
            layout: 'column',
            border: false,
            items: [{
                columnWidth: 1,
                layout: 'form',
                border: false,
                defaults: {
                    width: '97%'
                },
                items: [{
                    xtype: 'panel',
                    border: false,
                    style: 'border-bottom: 1px solid black; font-weight: bold;',
                    html: _('versionx.resources.detail.tabs.resource-content.columnheader', {id:config.vxRecord.version_id})
                },{
                    xtype: 'panel',
                    border: false,
                    style: 'padding: 15px 10px 10px 10px;',
                    html: (config.vxRecord) ? ((config.vxRecord.content) ? config.vxRecord.content : '<em>Empty</em>') : '<em>No Version Chosen</em>'
                }]
            }]
        }]
    });
    
    if ( config.vxRecordCmp ) {
        config.items[0].items[0].columnWidth = .5;
        config.items[0].items.push({
            columnWidth: .5,
            layout: 'form',
            border: false,
            defaults: {
                width: '97%'
            },
            items: [{
                xtype: 'panel',
                border: false,
                style: 'border-bottom: 1px solid black; font-weight: bold;',
                html: _('versionx.resources.detail.tabs.resource-content.columnheader', {id:config.vxRecordCmp.version_id})
            },{
                xtype: 'panel',
                border: false,
                style: 'padding: 15px 10px 10px 10px;',
                html: (config.vxRecordCmp) ? ((config.vxRecordCmp.content) ? config.vxRecordCmp.content : '<em>Empty</em>') : '<em>No Version Chosen</em>'
            }]
        });
    }
    
    VersionX.panel.ResourcesDetail.Content.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.panel.ResourcesDetail.Content,MODx.Panel,{});
Ext.reg('versionx-panel-resourcesdetail-content',VersionX.panel.ResourcesDetail.Content);