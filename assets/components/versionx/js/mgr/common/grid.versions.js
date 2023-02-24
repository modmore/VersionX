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
            {name: 'pagetitle_diff', type: 'string'},
            {name: 'longtitle_diff', type: 'string'},
            {name: 'description_diff', type: 'string'},
            {name: 'introtext_diff', type: 'string'},
            {name: 'content_diff', type: 'string'},
            {name: 'alias_diff', type: 'string'},
        ],
        paging: true,
        remoteSort: true,
        stripeRows: false,
        showActionsColumn: false,
        autoExpandColumn: 'time_end',
        columns: [{
            header: 'Versions',//_('versionx.content_id',{what: _('resource')}),
            dataIndex: 'time_end',
            renderer: this.diffColumnRenderer
        },{
            header: 'Details',
            dataIndex: 'version_id',
            fixed: true,
            width: 150,
            renderer: this.detailColumnRenderer,
            hidden: true
        }]
    });
    VersionX.grid.Versions.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.grid.Versions, MODx.grid.Grid, {
    diffColumnRenderer: function(v, p, rec) {
        return `<div class="versionx-grid-column-diff">
                    <div>${rec.get('pagetitle_diff')}</div>
                    <div>${rec.get('longtitle_diff')}</div>
                    <div>${rec.get('description_diff')}</div>
                    <div>${rec.get('introtext_diff')}</div>
                    <div>${rec.get('content_diff')}</div>
                </div>`;
    },
    detailColumnRenderer: function(v, p, rec) {

    },
});
Ext.reg('versionx-grid-versions', VersionX.grid.Versions);
