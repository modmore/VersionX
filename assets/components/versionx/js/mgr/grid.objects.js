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
            {name: 'name', type: 'string'},
        ],
        paging: true,
        pageSize: 20,
        remoteSort: true,
        filters: ['query', 'date_from', 'date_to', 'class', 'editor', 'package'],
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
            header: 'Name',
            dataIndex: 'name',
            width: 20,
            sortable: true,
        },{
            header: 'Class',
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
            header: 'Editor',
            dataIndex: 'username',
            width: 20,
            sortable: true,
        }]
        ,tbar: [{
            xtype: 'versionx-field-search',
            grid: this,
        },'->',{
            xtype: 'versionx-combo-classes',
            showClearFilter: true,
            listeners: {
                select: {
                    fn: this.filter,
                    scope: this
                },
            },
        },{
            xtype: 'versionx-combo-editors',
            showClearFilter: true,
            listeners: {
                select: {
                    fn: this.filter,
                    scope: this
                },
            },
        },{
            xtype: 'versionx-combo-packages',
            showClearFilter: true,
            listeners: {
                select: {
                    fn: this.filter,
                    scope: this
                },
            },
        },{
            xtype: 'datefield',
            name: 'date_from',
            emptyText: 'Date from...',
            format: 'Y-m-d',
            listeners: {
                select: {
                    fn: this.filter,
                    scope: this
                },
            },
        },{
            xtype: 'datefield',
            name: 'date_to',
            emptyText: 'Date to...',
            format: 'Y-m-d',
            listeners: {
                select: {
                    fn: this.filter,
                    scope: this
                },
            },
        },{
            text: '<i class="icon icon-close"></i>',
            handler: this.clearFilters,
        }]
    });
    VersionX.grid.Objects.superclass.constructor.call(this,config);
    this.config = config;
};
Ext.extend(VersionX.grid.Objects, MODx.grid.Grid, {
    filter: function (tf, nv, ov) {
        var value = tf.getValue();
        if (tf.xtype === 'datefield' && typeof value === 'object') {
            value = Ext.util.Format.date(value, 'Y-m-d');
        }
        this.getStore().baseParams[tf.name] = value;
        this.getBottomToolbar().changePage(1);
    },
    clearFilters: function() {
        var grid = this,
            s = this.getStore();
        this.config.filters.forEach(function(filter) {
            grid.getTopToolbar().find('name', filter)[0].reset();
            s.baseParams[filter] = '';
        });
        this.getBottomToolbar().changePage(1);
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