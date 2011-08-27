Ext.onReady(function() {
    Ext.QuickTips.init();
    MODx.load({ xtype: 'versionx-page-index'});
});

VersionX.page.Index = function(config) {
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
                title: _('versionx.home'),
                items: [{
                    xtype: 'versionx-panel-home',
                    border: false
                }]
            },{
                title: _('resources'),
                items: [{
                    xtype: 'versionx-panel-resources',
                    border: false
                },{
                    html: '<hr />',
                    border: false
                },{
                    xtype: 'versionx-grid-resources',
                    border: false
                }]
            },{
                title: _('templates'),
                items: [{
                    //xtype: 'versionx-grid-templates',
                    border: false
                }],
                disabled: true
            },{
                title: _('tmplvars'),
                items: [{
                    //xtype: 'versionx-grid-templatevars',
                    border: false
                }],
                disabled: true
            },{
                title: _('chunks'),
                items: [{
                    //xtype: 'versionx-grid-chunks',
                    border: false
                }],
                disabled: true
            },{
                title: _('snippets'),
                items: [{
                    //xtype: 'versionx-grid-snippets',
                    border: false
                }],
                disabled: true
            },{
                title: _('plugins'),
                items: [{
                    //xtype: 'versionx-grid-plugins',
                    border: false
                }],
                disabled: true
            }]

        }]
    });
    VersionX.page.Index.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.page.Index,MODx.Component);
Ext.reg('versionx-page-index',VersionX.page.Index);

/*
Index page header configuration.
 */
VersionX.panel.Header = function(config) {
    config = config || {};
    Ext.apply(config,{
        border: false
        ,baseCls: 'modx-formpanel'
        ,items: [{
            html: '<h2>'+_('versionx')+'</h2>'
            ,border: false
            ,cls: 'modx-page-header'
        }]
    });
    VersionX.panel.Header.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.panel.Header,MODx.Panel);
Ext.reg('versionx-panel-header',VersionX.panel.Header);



