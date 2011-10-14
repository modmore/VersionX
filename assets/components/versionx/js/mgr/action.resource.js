Ext.onReady(function() {
    Ext.QuickTips.init();
    page = MODx.load({ xtype: 'versionx-page-resource'});
    if (VersionX.record) {
        Ext.getCmp('versionx-panel-resourcesdetail').getForm().setValues(VersionX.record);

        for (i in VersionX.record.tvs) {
            tv = VersionX.record.tvs[i];
            if (typeof tv == 'object') {
                Ext.getCmp('versionx-resource-tvs').add({xtype: 'statictextfield', fieldLabel: tv['caption'], value: tv['value']})
            }
        }
        Ext.getCmp('versionx-resource-tvs').doLayout();
    }
    if (VersionX.cmrecord) {
        Ext.getCmp('versionx-panel-resourcesdetail').getForm().setValues(VersionX.cmrecord);

        for (i in VersionX.cmrecord.cm_tvs) {
            tv = VersionX.cmrecord.cm_tvs[i];
            if (typeof tv == 'object') {
                Ext.getCmp('versionx-resource-cm-tvs').add({xtype: 'statictextfield', fieldLabel: tv['caption'], value: tv['value']})
            }
        }
        Ext.getCmp('versionx-resource-cm-tvs').doLayout();
    }
    page.show();
});

VersionX.page.Resource = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        renderTo: 'versionx',
        components: [{
            xtype: 'versionx-panel-header'
        },{
            xtype: 'modx-tabs',
            width: '98%',
            bodyStyle: 'padding: 10px 10px 10px 10px;',
            border: true,
            defaults: {
                border: false,
                autoHeight: true,
                bodyStyle: 'padding: 5px 8px 5px 5px;'
            },
            items: [{
                title: _('versionx.resources.detail'),
                items: [{
                    xtype: 'versionx-panel-resourcesdetail',
                    border: false
                }]
            }]
        }],
        buttons: [{
            text: _('versionx.back'),
            handler: function () {
                window.location.href = '?a='+MODx.request['a'];
            }
        }]
    });
    VersionX.page.Resource.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.page.Resource,MODx.Component);
Ext.reg('versionx-page-resource',VersionX.page.Resource);

/*
Index page header configuration.
 */
VersionX.panel.Header = function(config) {
    config = config || {};
    Ext.apply(config,{
        border: false
        ,baseCls: 'modx-formpanel'
        ,items: [{
            html: '<h2>'+_('versionx')+' '+_('versionx.resources.detail')+'</h2>'
            ,border: false
            ,cls: 'modx-page-header'
        }]
    });
    VersionX.panel.Header.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.panel.Header,MODx.Panel);
Ext.reg('versionx-panel-header',VersionX.panel.Header);



