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
            type: config.type,
        },
        params: [],
        fields: [
            {name: 'version_id', type: 'int'},
            {name: 'username', type: 'string'},
            {name: 'time_start', type: 'string'},
            {name: 'time_end', type: 'string'},
            // {name: 'before', type: 'string'},
            // {name: 'after', type: 'string'},
            {name: 'diffs', type: 'string'},
        ],
        paging: true,
        remoteSort: true,
        stripeRows: false,
        showActionsColumn: false,
        hideHeaders: true,
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
        let diffs = rec.get('diffs'),
            name = rec.get('username');
        return `<div class="versionx-grid-column-diff">
                    <div class="versionx-diff-top-row">
                        <div>${name}</div>
                        <div class="right">
                            <button class="versionx-diff-revert-btn" type="button">Revert</button>
                            <div class="versionx-diff-menu"></div>
                        </div>
                    </div>
                    ${diffs}
                </div>`;
    },
    detailColumnRenderer: function(v, p, rec) {

    },
});
Ext.reg('versionx-grid-versions', VersionX.grid.Versions);
