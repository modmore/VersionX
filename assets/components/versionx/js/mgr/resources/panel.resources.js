
VersionX.panel.Resources = function(config) {
    config = config || {};
    Ext.apply(config,{
        id: 'versionx-panel-resources',
        border: false,
        forceLayout: true,
        width: '98%',
        items: [{
            html: '<p>'+_('versionx.resources.text')+'</p>'
        },{
            layout: 'column',
            border: false,
            items: [{
                columnWidth: '48%',
                layout: 'form',
                border: false,
                items: [{
                    xtype: 'textfield', //'versionx-combo-resources',
                    fieldLabel: _('resource'),
                    name: 'resource',
                    width: 200,
                    id: 'res-f-resource'
                },{
                    xtype: 'modx-combo-user',
                    fieldLabel: _('user'),
                    name: 'user',
                    width: 200,
                    id: 'res-f-user'
                },{
                    xtype: 'datefield',
                    fieldLabel: _('versionx.filter.datefrom'),
                    name: 'from',
                    width: 200,
                    id: 'res-f-from'
                }]
            },{
                columnWidth: '48%',
                layout: 'form',
                border: false,
                items: [{
                    xtype: 'modx-combo-context',
                    fieldLabel: _('context'),
                    name: 'context_key',
                    width: 200,
                    id: 'res-f-context'
                },{
                    xtype: 'modx-combo-class-map',
                    fieldLabel: _('class_key'),
                    name: 'class',
                    width: 200,
                    id: 'res-f-class'
                },{
                    xtype: 'datefield',
                    fieldLabel: _('versionx.filter.dateuntil'),
                    name: 'until',
                    width: 200,
                    id: 'res-f-until'
                }]
            }]
        },{
            layout: 'column',
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
Ext.extend(VersionX.panel.Resources,MODx.FormPanel,{
    doFilter: function() {
        g = Ext.getCmp('versionx-grid-resources');
        if (g) {
            fRes = Ext.getCmp('res-f-resource').getValue();
            g.baseParams['resource'] = fRes;
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
        g.baseParams['resource'] = '';
        g.baseParams['context'] = '';
        g.baseParams['class'] = '';
        g.baseParams['user'] = '';
        g.baseParams['from'] = '';
        g.baseParams['until'] = '';
        g.getBottomToolbar().changePage(1);
        g.refresh();
        Ext.getCmp('versionx-panel-resources').getForm().reset()
    }
});
Ext.reg('versionx-panel-resources',VersionX.panel.Resources);
