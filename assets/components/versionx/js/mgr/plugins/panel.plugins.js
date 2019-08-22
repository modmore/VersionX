VersionX.panel.Plugins = function(config) {
    config = config || {};
    Ext.apply(config,{
        id: 'versionx-panel-plugins',
        border: false,
        forceLayout: true,
        width: '98%',
        items: [{
            layout: 'column',
            border: false,
            items: [{
                columnWidth:.5,
                layout: 'form',
                border: false,
                items: [{
                    xtype: (VersionX.inVersion) ? 'hidden' : 'textfield', //'versionx-combo-plugins',
                    fieldLabel: _('plugin'),
                    name: 'fltr_plugin',
                    width: '95%',
                    id: 'plugin-f-plugin',
                    value: (VersionX.inVersion) ? MODx.request.id : ''
                },{
                    xtype: 'modx-combo-user',
                    fieldLabel: _('user'),
                    name: 'fltr_user',
                    hiddenName: 'fltr_user',
                    anchor: '1',
                    id: 'plugin-f-user'
                },{
                    xtype: 'datefield',
                    fieldLabel: _('versionx.filter.datefrom'),
                    name: 'fltr_from',
                    anchor: '1',
                    id: 'plugin-f-from'
                }]
            },{
                columnWidth:.5,
                layout: 'form',
                border: false,
                items: [{
                    xtype: (VersionX.inVersion) ? 'hidden' : 'modx-combo-category',
                    fieldLabel: _('category'),
                    name: 'fltr_category',
                    anchor: '1',
                    id: 'plugin-f-category'
                },{ 
                    fieldLabel: '',
                    style: 'height: 36px !important',
                    border: false
                },{
                    xtype: 'datefield',
                    fieldLabel: _('versionx.filter.dateuntil'),
                    name: 'fltr_until',
                    anchor: '1',
                    id: 'plugin-f-until'
                }]
            }]
        },{
            layout: 'column',
            padding: '10px 0 0 0',
            border: false,
            defaults: {
                border: false
            },
            items: [{
                width: 90,
                items: [{
                    border: false,
                    html: '&nbsp;'
                }]
            },{
                items: [{
                    xtype: 'button',
                    cls: 'primary-button',
                    handler: this.doFilter,
                    text: _('versionx.filter',{what: _('plugins')})
                }]
            },{
                items: [{
                    xtype: 'button',
                    handler: this.resetFilter,
                    text: _('versionx.filter.reset')
                }]
            },{
                columnWidth: 1,
                items: [{
                    html: '&nbsp;',
                    border: false
                }]
            }]
        }],
        listeners: {
            'success': function () {}
        }
    });
    VersionX.panel.Plugins.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.panel.Plugins,MODx.Panel,{
    doFilter: function() {
        var g = Ext.getCmp('versionx-grid-plugins');
        if (g) {
            g.baseParams['plugin'] = Ext.getCmp('plugin-f-plugin').getValue();
            g.baseParams['category'] = Ext.getCmp('plugin-f-category').getValue();
            g.baseParams['user'] = Ext.getCmp('plugin-f-user').getValue();
            g.baseParams['from'] = Ext.getCmp('plugin-f-from').getValue();
            g.baseParams['until'] = Ext.getCmp('plugin-f-until').getValue();
            g.getBottomToolbar().changePage(1);
            g.refresh();
        }
    },
    resetFilter: function() {
        var g = Ext.getCmp('versionx-grid-plugins');
        g.baseParams['plugin'] = (VersionX.inVersion) ? MODx.request.id : '';
        g.baseParams['category'] = '';
        g.baseParams['user'] = '';
        g.baseParams['from'] = '';
        g.baseParams['until'] = '';
        g.getBottomToolbar().changePage(1);
        g.refresh();

        Ext.getCmp('plugin-f-plugin').reset();
        Ext.getCmp('plugin-f-category').reset();
        Ext.getCmp('plugin-f-user').reset();
        Ext.getCmp('plugin-f-from').reset();
        Ext.getCmp('plugin-f-until').reset();
    }
});
Ext.reg('versionx-panel-plugins',VersionX.panel.Plugins);
