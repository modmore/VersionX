
VersionX.panel.Resources = function(config) {
    config = config || {};
    Ext.apply(config,{
        id: 'versionx-panel-resources',
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
                    xtype: (VersionX.inVersion) ? 'hidden' : 'textfield', //'versionx-combo-resources',
                    fieldLabel: _('resource'),
                    name: 'fltr_resource',
                    hiddenName: 'fltr_resource',
                    allowBlank: true,
                    width: '95%',
                    id: 'res-f-resource',
                    value: (VersionX.inVersion) ? MODx.request.id : ''
                },{
                    xtype: VersionX.config.has_users_permission ? 'modx-combo-user' : 'hidden',
                    fieldLabel: _('user'),
                    name: 'fltr_user',
                    hiddenName: 'fltr_user',
                    allowBlank: true,
                    anchor: '1',
                    id: 'res-f-user'
                },{
                    xtype: 'datefield',
                    fieldLabel: _('versionx.filter.datefrom'),
                    name: 'fltr_from',
                    anchor: '1',
                    id: 'res-f-from'
                }]
            },{
                columnWidth:.5,
                layout: 'form',
                border: false,
                items: [{
                    xtype: (VersionX.inVersion) ? 'hidden' : 'modx-combo-context',
                    fieldLabel: _('context'),
                    name: 'fltr_context_key',
                    hiddenName: 'fltr_context_key',
                    anchor: '1',
                    id: 'res-f-context'
                },{
                    xtype: 'modx-combo-class-derivatives',
                    fieldLabel: _('resource_type'),
                    name: 'fltr_class',
                    hiddenName: 'fltr_class',
                    allowBlank: true,
                    forceSelection: false,
                    anchor: '1',
                    id: 'res-f-class'
                },{
                    xtype: 'datefield',
                    fieldLabel: _('versionx.filter.dateuntil'),
                    name: 'fltr_until',
                    hiddenName: 'fltr_until',
                    allowBlank: true,
                    anchor: '1',
                    id: 'res-f-until'
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
                    text: _('versionx.filter',{what: _('resources')})
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
    VersionX.panel.Resources.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.panel.Resources,MODx.Panel,{
    doFilter: function() {
        var g = Ext.getCmp('versionx-grid-resources');
        if (g) {
            g.baseParams['resource'] = Ext.getCmp('res-f-resource').getValue();
            g.baseParams['context'] = Ext.getCmp('res-f-context').getValue();
            g.baseParams['class'] = Ext.getCmp('res-f-class').getValue();
            g.baseParams['user'] = Ext.getCmp('res-f-user').getValue();
            g.baseParams['from'] = Ext.getCmp('res-f-from').getValue();
            g.baseParams['until'] = Ext.getCmp('res-f-until').getValue();
            g.getBottomToolbar().changePage(1);
            g.refresh();
        }
    },
    resetFilter: function() {
        var g = Ext.getCmp('versionx-grid-resources');
        g.baseParams['resource'] = (VersionX.inVersion) ? MODx.request.id : '';
        g.baseParams['context'] = '';
        g.baseParams['class'] = '';
        g.baseParams['user'] = '';
        g.baseParams['from'] = '';
        g.baseParams['until'] = '';
        g.getBottomToolbar().changePage(1);
        g.refresh();
        
        // Reset Fields
        Ext.getCmp('res-f-resource').reset();
        Ext.getCmp('res-f-context').reset();
        Ext.getCmp('res-f-class').reset();
        Ext.getCmp('res-f-user').reset();
        Ext.getCmp('res-f-from').reset();
        Ext.getCmp('res-f-until').reset();
    }
});
Ext.reg('versionx-panel-resources',VersionX.panel.Resources);
