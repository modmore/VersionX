Ext.onReady(function() {
    Ext.QuickTips.init();
    MODx.load({ xtype: 'versionx-page-index'});
});

VersionX.page.Index = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        renderTo: 'versionx',
        cls: 'container',
        components: [{
            html: '<h2>'+_('versionx')+'</h2>',
            border: false,
            cls: 'modx-page-header',
            xtype: 'panel'
        },{
            xtype: 'modx-tabs',
            cls: 'structure-tabs',
            width: '98%',
            border: true,
            defaults: {
                border: false,
                autoHeight: true,
                cls: 'main-wrapper'
            },
            items: [{
                title: _('versionx.home'),
                items: [{
                    html: '<p>'+_('versionx.home.text')+'</p>',
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
