
VersionX.panel.TemplateVariables = function(config) {
    config = config || {};
    Ext.apply(config,{
        id: 'versionx-panel-templatevars',
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
                    fieldLabel: _('tv'),
                    name: 'fltr_templatevar',
                    width: '95%',
                    id: 'tmplvar-f-templatevar',
                    value: (VersionX.inVersion) ? MODx.request.id : ''
                    
                },{
                    xtype: 'modx-combo-user',
                    fieldLabel: _('user'),
                    name: 'fltr_user',
                    hiddenName: 'fltr_user',
                    anchor: '1',
                    id: 'tmplvar-f-user'
                },{
                    xtype: 'datefield',
                    fieldLabel: _('versionx.filter.datefrom'),
                    name: 'fltr_from',
                    anchor: '1',
                    id: 'tmplvar-f-from'
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
                    id: 'tmplvar-f-category'
                },{ 
                    fieldLabel: '',
                    style: 'height: 44px !important',
                    border: false
                },{
                    xtype: 'datefield',
                    fieldLabel: _('versionx.filter.dateuntil'),
                    name: 'fltr_until',
                    anchor: '1',
                    id: 'tmplvar-f-until'
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
                    text: _('versionx.filter',{what: _('tmplvars')})
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
            'success': function (res) {
            }
        }
    });
    VersionX.panel.TemplateVariables.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.panel.TemplateVariables,MODx.Panel,{
    doFilter: function() {
        g = Ext.getCmp('versionx-grid-templatevars');
        if (g) {
            fRes = Ext.getCmp('tmplvar-f-templatevar').getValue();
            g.baseParams['search'] = fRes;
            fCat = Ext.getCmp('tmplvar-f-category').getValue();
            g.baseParams['category'] = fCat;
            fUsr = Ext.getCmp('tmplvar-f-user').getValue();
            g.baseParams['user'] = fUsr;
            fFrm = Ext.getCmp('tmplvar-f-from').getValue();
            g.baseParams['from'] = fFrm;
            fUnt = Ext.getCmp('tmplvar-f-until').getValue();
            g.baseParams['until'] = fUnt;
            g.getBottomToolbar().changePage(1);
            g.refresh();
        }
    },
    resetFilter: function() {
        g = Ext.getCmp('versionx-grid-templatevars');
        g.baseParams['templatevar'] = (VersionX.inVersion) ? MODx.request.id : '';
        g.baseParams['category'] = '';
        g.baseParams['user'] = '';
        g.baseParams['from'] = '';
        g.baseParams['until'] = '';
        g.getBottomToolbar().changePage(1);
        g.refresh();

        Ext.getCmp('tmplvar-f-templatevar').reset();
        Ext.getCmp('tmplvar-f-category').reset();
        Ext.getCmp('tmplvar-f-user').reset();
        Ext.getCmp('tmplvar-f-from').reset();
        Ext.getCmp('tmplvar-f-until').reset();
    }
});
Ext.reg('versionx-panel-templatevars',VersionX.panel.TemplateVariables);
