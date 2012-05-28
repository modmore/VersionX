
VersionX.panel.Chunks = function(config) {
    config = config || {};
    Ext.apply(config,{
        id: 'versionx-panel-chunks',
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
                    xtype: (VersionX.inVersion) ? 'hidden' : 'textfield', //'versionx-combo-chunks',
                    fieldLabel: _('chunk'),
                    name: 'fltr_chunk',
                    width: 200,
                    id: 'chk-f-chunk',
                    value: (VersionX.inVersion) ? MODx.request.id : ''
                    
                },{
                    xtype: 'modx-combo-user',
                    fieldLabel: _('user'),
                    name: 'fltr_user',
                    hiddenName: 'fltr_user',
                    width: 200,
                    id: 'chk-f-user'
                },{
                    xtype: 'datefield',
                    fieldLabel: _('versionx.filter.datefrom'),
                    name: 'fltr_from',
                    width: 200,
                    id: 'chk-f-from'
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
                    id: 'chk-f-category'
                },{ 
                    fieldLabel: '',
                    style: 'height: 36px !important',
                    border: false
                },{
                    xtype: 'datefield',
                    fieldLabel: _('versionx.filter.dateuntil'),
                    name: 'fltr_until',
                    width: 200,
                    id: 'chk-f-until'
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
                    text: _('versionx.filter',{what: _('chunks')})
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
    VersionX.panel.Chunks.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.panel.Chunks,MODx.Panel,{
    doFilter: function() {
        g = Ext.getCmp('versionx-grid-chunks');
        if (g) {
            fRes = Ext.getCmp('chk-f-chunk').getValue();
            g.baseParams['chunk'] = fRes;
            fCat = Ext.getCmp('chk-f-category').getValue();
            g.baseParams['category'] = fCat;
            fUsr = Ext.getCmp('chk-f-user').getValue();
            g.baseParams['user'] = fUsr;
            fFrm = Ext.getCmp('chk-f-from').getValue();
            g.baseParams['from'] = fFrm;
            fUnt = Ext.getCmp('chk-f-until').getValue();
            g.baseParams['until'] = fUnt;
            g.getBottomToolbar().changePage(1);
            g.refresh();
        }
    },
    resetFilter: function() {
        g = Ext.getCmp('versionx-grid-chunks');
        g.baseParams['chunk'] = (VersionX.inVersion) ? MODx.request.id : '';
        g.baseParams['category'] = '';
        g.baseParams['user'] = '';
        g.baseParams['from'] = '';
        g.baseParams['until'] = '';
        g.getBottomToolbar().changePage(1);
        g.refresh();

        Ext.getCmp('chk-f-chunk').reset();
        Ext.getCmp('chk-f-category').reset();
        Ext.getCmp('chk-f-user').reset();
        Ext.getCmp('chk-f-from').reset();
        Ext.getCmp('chk-f-until').reset();
    }
});
Ext.reg('versionx-panel-chunks',VersionX.panel.Chunks);
