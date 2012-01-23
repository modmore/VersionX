
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
                columnWidth: '48%',
                layout: 'form',
                border: false,
                items: [{
                    xtype: (VersionX.inVersion) ? 'hidden' : 'modx-combo-template', //'versionx-combo-templates',
                    fieldLabel: _('template'),
                    name: 'fltr_template',
                    width: 200,
                    id: 'tpl-f-template',
                    value: (VersionX.inVersion) ? MODx.request.id : ''
                    
                },{
                    xtype: 'modx-combo-user',
                    fieldLabel: _('user'),
                    name: 'fltr_user',
                    width: 200,
                    id: 'tpl-f-user'
                },{
                    xtype: 'datefield',
                    fieldLabel: _('versionx.filter.datefrom'),
                    name: 'fltr_from',
                    width: 200,
                    id: 'tpl-f-from'
                }]
            },{
                columnWidth: '48%',
                layout: 'form',
                border: false,
                items: [{
                    xtype: (VersionX.inVersion) ? 'hidden' : 'modx-combo-category',
                    fieldLabel: _('category'),
                    name: 'fltr_category',
                    width: 200,
                    id: 'tpl-f-category'
                },{ 
                    fieldLabel: '',
                    style: 'height: 36px !important',
                    border: false
                },{
                    xtype: 'datefield',
                    fieldLabel: _('versionx.filter.dateuntil'),
                    name: 'fltr_until',
                    width: 200,
                    id: 'tpl-f-until'
                }]
            }]
        },{
            layout: 'column',
            padding: '10px 0 0 0',
            border: false,
            items: [{
                columnWidth: '30%',
                border: false,
                items: [{
                    xtype: 'button',
                    handler: this.doFilter,
                    text: _('versionx.filter',{what: _('templates')})
                }]
            },{
                columnWidth: '30%',
                border: false,
                items: [{
                     xtype: 'button',
                    handler: this.resetFilter,
                    text: _('versionx.filter.reset')
                }]
            }]
        }],
        listeners: {
            'success': function (res) {
            }
        }
    });
    VersionX.panel.Templates.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.panel.Templates,MODx.Panel,{
    doFilter: function() {
        g = Ext.getCmp('versionx-grid-templates');
        if (g) {
            fRes = Ext.getCmp('tpl-f-template').getValue();
            g.baseParams['template'] = fRes;
            fCat = Ext.getCmp('tpl-f-category').getValue();
            g.baseParams['category'] = fCat;
            fUsr = Ext.getCmp('tpl-f-user').getValue();
            g.baseParams['user'] = fUsr;
            fFrm = Ext.getCmp('tpl-f-from').getValue();
            g.baseParams['from'] = fFrm;
            fUnt = Ext.getCmp('tpl-f-until').getValue();
            g.baseParams['until'] = fUnt;
            g.getBottomToolbar().changePage(1);
            g.refresh();
        }
    },
    resetFilter: function() {
        g = Ext.getCmp('versionx-grid-templates');
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
