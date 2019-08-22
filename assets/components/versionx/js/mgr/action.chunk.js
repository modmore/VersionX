
Ext.applyIf(VersionX.panel, {ChunksDetail:{}});
Ext.applyIf(VersionX.grid, {ChunksDetail:{}});

Ext.onReady(function() {
    Ext.QuickTips.init();
    page = MODx.load({ xtype: 'versionx-page-chunk'});
    page.show();
});

VersionX.page.Chunk = function(config) {
    config = config || {};
    var buttons = [];
    buttons.push({
        text: _('versionx.back'),
        handler: function () {
            MODx.loadPage('?namespace=versionx&a=index');
        }
    });
    if (MODx.request.backTo) {
        var back = MODx.request.backTo.split('-');
        buttons.push('-',{
            text: _('versionx.backto',{what: _('chunk')}),
            handler: function() {
                MODx.loadPage('?a='+back[0]+'&id='+back[1]);
            }
        });
    }
    Ext.applyIf(config,{
        renderTo: 'versionx',
        cls: 'container',
        components: [{
            xtype: 'panel',
            html: '<h2>'+_('versionx')+' '+_('versionx.chunks.detail')+'</h2>',
            cls: 'modx-page-header',
            border: false
        },{
            xtype: !VersionX.record ? 'versionx-panel-notfound' : 'versionx-panel-chunksdetail',
            cls: 'x-panel-body',
            vxRecord: VersionX.record,
            vxRecordCmp: VersionX.cmrecord,
            border: false,
            width: '98%'
        }],
        buttons: buttons
    });
    VersionX.page.Chunk.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.page.Chunk,MODx.Component);
Ext.reg('versionx-page-chunk',VersionX.page.Chunk);

