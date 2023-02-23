VersionX.grid.Versions = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        url: VersionX.config.connector_url,
        id: 'versionx-grid-versions',
        cls: 'versionx-grid-versions',
        baseParams: {
            action: 'mgr/versions/getlist',
            principal_package: config.principal_package,
            principal_class: config.principal_class,
            principal: config.principal,
        },
        params: [],
        fields: [
            {name: 'version_id', type: 'int'},
            {name: 'time_start', type: 'string'},
            {name: 'time_end', type: 'string'},
            // {name: 'before', type: 'string'},
            // {name: 'after', type: 'string'},
            {name: 'content_diff', type: 'string'},
        ],
        paging: true,
        remoteSort: true,
        stripeRows: false,
        showActionsColumn: false,
        autoExpandColumn: 'time_end',
        columns: [{
            header: 'Versions',//_('versionx.content_id',{what: _('resource')}),
            dataIndex: 'time_end',
            sortable: true,
            renderer: this.diffColumnRenderer
        },{
            header: 'Details',
            dataIndex: 'version_id',
            sortable: true,
            fixed: true,
            width: 150,
            renderer: this.detailColumnRenderer
        }]
    });
    VersionX.grid.Versions.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.grid.Versions, MODx.grid.Grid, {
    diffColumnRenderer: function(v, p, rec) {
        return `<div class="versionx-grid-column-diff">${rec.get('content_diff')}</div>`;
    },
    detailColumnRenderer: function(v, p, rec) {

    },
});
Ext.reg('versionx-grid-versions', VersionX.grid.Versions);
