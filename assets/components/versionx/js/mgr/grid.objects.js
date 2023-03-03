VersionX.grid.Objects = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        url: VersionX.config.connector_url,
        id: 'versionx-grid-objects',
        cls: 'versionx-grid-objects',
        bodyCssClass: 'versionx-grid-objects-body',
        baseParams: {
            action: 'mgr/objects/getlist',
        },
        fields: [
            {name: 'id', type: 'int'},
            {name: 'principal_package', type: 'string'},
            {name: 'principal_class', type: 'string'},
            {name: 'principal', type: 'int'},
            {name: 'type', type: 'string'},
            {name: 'time_start', type: 'string'},
            {name: 'time_end', type: 'string'},
            {name: 'user_id', type: 'int'},
            {name: 'username', type: 'string'},
        ],
        paging: true,
        remoteSort: true,
        columns: [{
            header: 'Delta',
            dataIndex: 'id',
            hidden: true
        },{
            header: 'When',
            dataIndex: 'time_end',
            width: 20,
            sortable: true,
        },{
            header: 'Object',
            dataIndex: 'principal_class',
            width: 20,
            sortable: true,
        },{
            header: 'ID',
            dataIndex: 'principal',
            width: 10,
            sortable: true,
        },{
            header: 'Package',
            dataIndex: 'principal_package',
            width: 10,
            sortable: true,
        },{
            header: 'User',
            dataIndex: 'username',
            width: 20,
            sortable: true,
        }]
        ,tbar: [{
            xtype: 'versionx-field-search',
            grid: this,
            width: 400,
        },'->',{
            xtype: 'datefield',
            name: 'date_from',
            emptyText: 'Date from...',
            format: 'Y-m-d',
        },{
            xtype: 'datefield',
            name: 'date_to',
            emptyText: 'Date to...',
            format: 'Y-m-d',
        }]
    });
    VersionX.grid.Objects.superclass.constructor.call(this,config);
    this.config = config;
};
Ext.extend(VersionX.grid.Objects, MODx.grid.Grid, {
    search: function (tf, nv, ov) {
        let s = this.getStore();
        s.baseParams.query = tf.getValue();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    },
    getMenu: function() {
        var m = [];
        m.push({
            text: 'View Details',
            handler: this.viewDetails
        });
        return m;
    },
    viewDetails: function(v, e) {
        if (this.viewDetailsWindow) {
            this.viewDetailsWindow.destroy();
        }

        this.viewDetailsWindow = MODx.load({
            xtype: 'versionx-window-deltas',
            record: this.menu.record,
            listeners: {
                'success': {fn: this.refresh, scope: this}
            }
        });
        this.viewDetailsWindow.show(e.target);
    },
});
Ext.reg('versionx-grid-objects', VersionX.grid.Objects);