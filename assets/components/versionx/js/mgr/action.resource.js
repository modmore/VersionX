
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
        components: [{
            xtype: 'versionx-panel-header'
        },{
            xtype: 'versionx-panel-resourcesdetail',
            vxRecord: VersionX.record,
            vxRecordCmp: VersionX.cmrecord,
            border: false
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
            html: '<h2>'+_('versionx')+' '+_('versionx.resources.detail')+'</h2><p style="margin: 0 0 10px 3px;">'+_('versionx.resources.detail.text')+'</p>'
            ,border: false
            ,cls: 'modx-page-header'
        }]
    });
    VersionX.panel.Header.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.panel.Header,MODx.Panel);
Ext.reg('versionx-panel-header',VersionX.panel.Header);



