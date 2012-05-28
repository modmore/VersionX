
Ext.applyIf(VersionX.panel, {ResourcesDetail:{}});
Ext.applyIf(VersionX.grid, {ResourcesDetail:{}});

Ext.onReady(function() {
    Ext.QuickTips.init();
    page = MODx.load({ xtype: 'versionx-page-resource'});
    page.show();
});

VersionX.page.Resource = function(config) {
    config = config || {};
    var buttons = [];
    buttons.push({
        text: _('versionx.back'),
        handler: function () {
            window.location.href = '?a='+MODx.request['a'];
        }
    });
    if (MODx.request.backTo) {
        var back = MODx.request.backTo.split('-');
        buttons.push('-',{
            text: _('versionx.backto',{what: _('resource')}),
            handler: function() {
                window.location.href = '?a='+back[0]+'&id='+back[1];
            }
        });
    }
    Ext.applyIf(config,{
        renderTo: 'versionx',
        cls: 'container',
        components: [{
            xtype: 'panel',
            html: '<h2>'+_('versionx')+' '+_('versionx.resources.detail')+'</h2>',
            cls: 'modx-page-header',
            border: false
        },{
            xtype: 'versionx-panel-resourcesdetail',
            cls: 'x-panel-body',
            vxRecord: VersionX.record,
            vxRecordCmp: VersionX.cmrecord,
            border: false,
            width: '98%'
        }],
        buttons: buttons
    });
    VersionX.page.Resource.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.page.Resource,MODx.Component);
Ext.reg('versionx-page-resource',VersionX.page.Resource);

