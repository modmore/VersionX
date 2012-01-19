
Ext.applyIf(VersionX.panel, {ResourcesDetail:{}});
Ext.applyIf(VersionX.grid, {ResourcesDetail:{}});

Ext.onReady(function() {
    Ext.QuickTips.init();
    page = MODx.load({ xtype: 'versionx-page-resource'});
    page.show();
});

VersionX.page.Resource = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        renderTo: 'versionx',
        cls: 'container',
        components: [{
            xtype: 'versionx-panel-header',
            cls: 'modx-page-header'
        },{
            xtype: 'versionx-panel-resourcesdetail',
            cls: 'x-panel-body',
            vxRecord: VersionX.record,
            vxRecordCmp: VersionX.cmrecord,
            border: false,
                    width: '98%'
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
        border: false,
        items: [{
            html: '<h2>'+_('versionx')+' '+_('versionx.resources.detail')+'</h2>',
            border: false
        }]
    });
    VersionX.panel.Header.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.panel.Header,MODx.Panel,{});
Ext.reg('versionx-panel-header',VersionX.panel.Header);



