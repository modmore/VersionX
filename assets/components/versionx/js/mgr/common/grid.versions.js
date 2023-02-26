VersionX.grid.Versions = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        url: VersionX.config.connector_url,
        id: 'versionx-grid-versions',
        cls: 'versionx-grid-versions',
        bodyCssClass: 'versionx-grid-versions-body',
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
    VersionX.grid.Versions.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.grid.Versions, MODx.grid.Grid, {
    search: function (tf, nv, ov) {
        var s = this.getStore();
        s.baseParams.query = tf.getValue();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    },
    diffColumnRenderer: function(v, p, rec) {
        let diffs = rec.get('diffs'),
            name = rec.get('username'),
            time_end = rec.get('time_end');
        return `<div class="versionx-grid-diff-container">
                    <div class="versionx-grid-timeline">
                        <div class="versionx-grid-timeline-line"></div>
                        <div class="versionx-grid-timeline-point"></div>
                    </div>
                    <div class="versionx-grid-column-diff">
                        <div class="versionx-diff-top-row">
                            <div class="versionx-diff-top-row-left">
                                <div class="versionx-diff-times">${time_end}</div>
                                <div class="versionx-diff-usernames">${name}</div>
                            </div>
                            <div class="versionx-diff-top-row-right">
                                <button class="versionx-diff-revert-btn" type="button">Revert</button>
                                <div class="versionx-diff-menu"></div>
                            </div>
                        </div>
                        ${diffs}
                    </div>
                </div>`;
    },
    detailColumnRenderer: function(v, p, rec) {

    },
});
Ext.reg('versionx-grid-versions', VersionX.grid.Versions);


/**
 * @param config
 * @constructor
 */
VersionX.field.Search = function(config) {
    config = config || {};
    var grid = config.grid || null

    Ext.applyIf(config, {
        xtype: 'trigger',
        name: 'query',
        emptyText: _('versionx.search'),
        width: 250,
        ctCls: 'versionx-search',
        onTriggerClick: function() {
            this.reset();
            this.fireEvent('click');
        },
        listeners: {
            'render': {
                fn: function(cmp) {
                    new Ext.KeyMap(cmp.getEl(), {
                        key: Ext.EventObject.ENTER,
                        fn: function() {
                            grid.search(this);
                            return true;
                        },
                        scope: cmp
                    });
                },
                scope:grid,
            },
            'click': {
                fn: function(trigger) {
                    grid.getStore().setBaseParam('query', '');
                    grid.getStore().load();
                },
                scope: grid
            }
        }
    });
    VersionX.field.Search.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.field.Search, Ext.form.TriggerField);
Ext.reg('versionx-field-search', VersionX.field.Search);
