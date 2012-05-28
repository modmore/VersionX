
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
                columnWidth: '48%',
                layout: 'form',
                border: false,
                items: [{
                    xtype: (VersionX.inVersion) ? 'hidden' : 'textfield', //'versionx-combo-resources',
                    fieldLabel: _('resource'),
                    name: 'fltr_resource',
                    width: 200,
                    id: 'res-f-resource',
                    value: (VersionX.inVersion) ? MODx.request.id : ''
                    
                },{
                    xtype: 'modx-combo-user',
                    fieldLabel: _('user'),
                    name: 'fltr_user',
                    hiddenName: 'fltr_user',
                    width: 200,
                    id: 'res-f-user'
                },{
                    xtype: 'datefield',
                    fieldLabel: _('versionx.filter.datefrom'),
                    name: 'fltr_from',
                    width: 200,
                    id: 'res-f-from'
                }]
            },{
                columnWidth: '48%',
                layout: 'form',
                border: false,
                items: [{
                    xtype: (VersionX.inVersion) ? 'hidden' : 'modx-combo-context',
                    fieldLabel: _('context'),
                    name: 'fltr_context_key',
                    width: 200,
                    id: 'res-f-context'
                },{
                    xtype: 'modx-combo-class-map',
                    fieldLabel: _('class_key'),
                    name: 'fltr_class',
                    width: 200,
                    id: 'res-f-class'
                },{
                    xtype: 'datefield',
                    fieldLabel: _('versionx.filter.dateuntil'),
                    name: 'fltr_until',
                    width: 200,
                    id: 'res-f-until'
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
                    text: _('versionx.filter',{what: _('resources')})
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
    VersionX.panel.Resources.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.panel.Resources,MODx.Panel,{
    doFilter: function() {
        g = Ext.getCmp('versionx-grid-resources');
        if (g) {
            fRes = Ext.getCmp('res-f-resource').getValue();
            g.baseParams['search'] = fRes;
            fCtx = Ext.getCmp('res-f-context').getValue();
            g.baseParams['context'] = fCtx;
            fCls = Ext.getCmp('res-f-class').getValue();
            g.baseParams['class'] = fCls;
            fUsr = Ext.getCmp('res-f-user').getValue();
            g.baseParams['user'] = fUsr;
            fFrm = Ext.getCmp('res-f-from').getValue();
            g.baseParams['from'] = fFrm;
            fUnt = Ext.getCmp('res-f-until').getValue();
            g.baseParams['until'] = fUnt;
            g.getBottomToolbar().changePage(1);
            g.refresh();
        }
    },
    resetFilter: function() {
        g = Ext.getCmp('versionx-grid-resources');
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
