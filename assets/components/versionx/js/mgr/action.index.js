Ext.onReady(function() {
    Ext.QuickTips.init();
    MODx.load({
        xtype: 'versionx-page-index',
        renderTo: 'versionx'
    });
});

VersionX.page.Index = function(config) {
    config = config || {};
    config.id = config.id || 'versionx-panel-index';
    Ext.applyIf(config, {
        cls: 'container form-with-labels',
        components: [{
            xtype: 'panel',
            html: '<h2>'+_('versionx')+'</h2>',
            border: false,
            cls: 'modx-page-header',
            bodyStyle: 'margin: 20px 0 0 0;'
        },{
            xtype: 'modx-tabs',
            width: '98%',
            border: true,
            defaults: {
                border: false,
                autoHeight: true,
                cls: 'main-wrapper',
                defaults: {
                    border: false
                }
            },
            items: [{
                title: _('versionx'),
                items: [{
                    html: '<p>'+_('versionx.home.text')+'</p>',
                    border: false
                }]
            },{
                title: _('resources'),
                items: [{
                    xtype: 'versionx-panel-resources'
                },{
                    html: '<hr />'
                },{
                    xtype: 'versionx-grid-resources'
                }]
            },{
                title: _('templates'),
                items: [{
                    xtype: 'versionx-panel-templates'
                },{
                    html: '<hr />'
                },{
                    xtype: 'versionx-grid-templates'
                }]
            },{
                title: _('tmplvars'),
                items: [{
                    xtype: 'versionx-panel-templatevars'
                },{
                    html: '<hr />'
                },{
                    xtype: 'versionx-grid-templatevars'
                }]
            },{
                title: _('chunks'),
                items: [{
                    xtype: 'versionx-panel-chunks'
                },{
                    html: '<hr />'
                },{
                    xtype: 'versionx-grid-chunks'
                }]
            },{
                title: _('snippets'),
                items: [{
                    xtype: 'versionx-panel-snippets'
                },{
                    html: '<hr />'
                },{
                    xtype: 'versionx-grid-snippets'
                }]
            },{
                title: _('plugins'),
                items: [{
                    xtype: 'versionx-panel-plugins'
                },{
                    html: '<hr />'
                },{
                    xtype: 'versionx-grid-plugins'
                }]
            }],
            stateful: true,
            stateId: config.id,
            stateEvents: ['tabchange'],
            getState: function() {
                return { activeTab:this.items.indexOf(this.getActiveTab()) };
            }
        }]
    });
    VersionX.page.Index.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.page.Index,MODx.Component);
Ext.reg('versionx-page-index',VersionX.page.Index);
