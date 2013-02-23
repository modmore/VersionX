VersionX.page.Base = function(config) {
    config = config || {};
    config.type = config.type || '';

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
            text: _('versionx.backto',{what: _(config.type)}),
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
            html: '<h2>'+_('versionx')+' '+_('versionx.'+config.type+'s.detail')+'</h2>',
            cls: 'modx-page-header',
            border: false
        },{
            xtype: 'versionx-panel-'+config.type+'sdetail',
            cls: 'x-panel-body',
            vxRecord: VersionX.record,
            vxRecordCmp: VersionX.cmrecord,
            border: false,
            width: '98%'
        }],
        buttons: buttons
    });
    VersionX.page.Base.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.page.Base,MODx.Component);
Ext.reg('versionx-page-base',VersionX.page.Base);
