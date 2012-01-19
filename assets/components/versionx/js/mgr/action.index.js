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
            xtype: 'panel',
            html: '<h2>'+_('versionx')+'</h2>',
            border: false,
            cls: 'modx-page-header'
        },{
            xtype: 'panel',
            cls: 'x-panel-body',
            border: false,
            items: [{
                html: '<p>'+_('versionx.home.text')+'</p>',
                border: false,
                bodyCssClass: 'panel-desc'
            },{
                cls: 'main-wrapper',
                border: false,
                items: [{
                    xtype: 'modx-tabs',
                    cls: 'structure-tabs',
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
                        title: _('resources'),
                        items: [{
                            html: '<p>'+_('versionx.resources.text')+'</p>',
                            padding: '0 0 10px 0'
                        },{
                            xtype: 'versionx-panel-resources'
                        },{
                            html: '<hr />'
                        },{
                            xtype: 'versionx-grid-resources'
                        }]
                    },{
                        title: _('templates'),
                        items: [{
                            //xtype: 'versionx-grid-templates'
                        }],
                        disabled: true
                    },{
                        title: _('tmplvars'),
                        items: [{
                            //xtype: 'versionx-grid-templatevars'
                        }],
                        disabled: true
                    },{
                        title: _('chunks'),
                        items: [{
                            //xtype: 'versionx-grid-chunks'
                        }],
                        disabled: true
                    },{
                        title: _('snippets'),
                        items: [{
                            //xtype: 'versionx-grid-snippets'
                        }],
                        disabled: true
                    },{
                        title: _('plugins'),
                        items: [{
                            //xtype: 'versionx-grid-plugins'
                        }],
                        disabled: true
                    }]
                }]
            }]
        }]
    });
    VersionX.page.Index.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.page.Index,MODx.Component);
Ext.reg('versionx-page-index',VersionX.page.Index);
