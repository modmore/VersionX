
VersionX.panel.Templates = function(config) {
    config = config || {};
    Ext.apply(config,{
        id: 'versionx-panel-templates',
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
                    xtype: (VersionX.inVersion) ? 'hidden' : 'textfield', //'versionx-combo-templates',
                    fieldLabel: _('template'),
                    name: 'fltr_template',
                    width: '95%',
                    id: 'tpl-f-template',
                    value: (VersionX.inVersion) ? MODx.request.id : ''
                    
                },{
                    xtype: 'modx-combo-user',
                    fieldLabel: _('user'),
                    name: 'fltr_user',
                    hiddenName: 'fltr_user',
                    anchor: '1',
                    id: 'tpl-f-user'
                },{
                    xtype: 'datefield',
                    fieldLabel: _('versionx.filter.datefrom'),
                    name: 'fltr_from',
                    anchor: '1',
                    id: 'tpl-f-from'
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
                    id: 'tpl-f-category'
                },{
                    xtype: 'datefield',
                    fieldLabel: _('versionx.filter.dateuntil'),
                    name: 'fltr_until',
                    anchor: '1',
                    id: 'tpl-f-until'
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
                    text: _('versionx.filter',{what: _('templates')})
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
    VersionX.panel.Templates.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.panel.Templates,MODx.Panel,{
    doFilter: function() {
        var g = Ext.getCmp('versionx-grid-templates');
        if (g) {
            g.baseParams['template'] = Ext.getCmp('tpl-f-template').getValue();
            g.baseParams['category'] = Ext.getCmp('tpl-f-category').getValue();
            g.baseParams['user'] = Ext.getCmp('tpl-f-user').getValue();
            g.baseParams['from'] = Ext.getCmp('tpl-f-from').getValue();
            g.baseParams['until'] = Ext.getCmp('tpl-f-until').getValue();
            g.getBottomToolbar().changePage(1);
            g.refresh();
        }
    },
    resetFilter: function() {
        var g = Ext.getCmp('versionx-grid-templates');
        g.baseParams['template'] = (VersionX.inVersion) ? MODx.request.id : '';
        g.baseParams['category'] = '';
        g.baseParams['user'] = '';
        g.baseParams['from'] = '';
        g.baseParams['until'] = '';
        g.getBottomToolbar().changePage(1);
        g.refresh();

        Ext.getCmp('tpl-f-template').reset();
        Ext.getCmp('tpl-f-category').reset();
        Ext.getCmp('tpl-f-user').reset();
        Ext.getCmp('tpl-f-from').reset();
        Ext.getCmp('tpl-f-until').reset();
    }
});
Ext.reg('versionx-panel-templates',VersionX.panel.Templates);
