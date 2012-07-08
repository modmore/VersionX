
VersionX.panel.Snippets = function(config) {
    config = config || {};
    Ext.apply(config,{
        id: 'versionx-panel-snippets',
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
                    xtype: (VersionX.inVersion) ? 'hidden' : 'textfield', //'versionx-combo-snippets',
                    fieldLabel: _('snippet'),
                    name: 'fltr_snippet',
                    width: '95%',
                    id: 'chk-f-snippet',
                    value: (VersionX.inVersion) ? MODx.request.id : ''
                    
                },{
                    xtype: 'modx-combo-user',
                    fieldLabel: _('user'),
                    name: 'fltr_user',
                    hiddenName: 'fltr_user',
                    anchor: '1',
                    id: 'chk-f-user'
                },{
                    xtype: 'datefield',
                    fieldLabel: _('versionx.filter.datefrom'),
                    name: 'fltr_from',
                    anchor: '1',
                    id: 'chk-f-from'
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
                    id: 'chk-f-category'
                },{ 
                    fieldLabel: '',
                    style: 'height: 36px !important',
                    border: false
                },{
                    xtype: 'datefield',
                    fieldLabel: _('versionx.filter.dateuntil'),
                    name: 'fltr_until',
                    anchor: '1',
                    id: 'chk-f-until'
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
                    handler: this.doFilter,
                    text: _('versionx.filter',{what: _('snippets')})
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
    VersionX.panel.Snippets.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.panel.Snippets,MODx.Panel,{
    doFilter: function() {
        var g = Ext.getCmp('versionx-grid-snippets');
        if (g) {
            g.baseParams['search'] = Ext.getCmp('chk-f-snippet').getValue();
            g.baseParams['category'] = Ext.getCmp('chk-f-category').getValue();
            g.baseParams['user'] = Ext.getCmp('chk-f-user').getValue();
            g.baseParams['from'] = Ext.getCmp('chk-f-from').getValue();
            g.baseParams['until'] = Ext.getCmp('chk-f-until').getValue();
            g.getBottomToolbar().changePage(1);
            g.refresh();
        }
    },
    resetFilter: function() {
        var g = Ext.getCmp('versionx-grid-snippets');
        g.baseParams['snippet'] = (VersionX.inVersion) ? MODx.request.id : '';
        g.baseParams['category'] = '';
        g.baseParams['user'] = '';
        g.baseParams['from'] = '';
        g.baseParams['until'] = '';
        g.getBottomToolbar().changePage(1);
        g.refresh();

        Ext.getCmp('chk-f-snippet').reset();
        Ext.getCmp('chk-f-category').reset();
        Ext.getCmp('chk-f-user').reset();
        Ext.getCmp('chk-f-from').reset();
        Ext.getCmp('chk-f-until').reset();
    }
});
Ext.reg('versionx-panel-snippets',VersionX.panel.Snippets);
