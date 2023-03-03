VersionX.grid.Deltas = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        url: VersionX.config.connector_url,
        id: 'versionx-grid-deltas',
        itemId: 'versionx-grid-deltas',
        cls: 'versionx-grid-deltas',
        bodyCssClass: 'versionx-grid-deltas-body',
        baseParams: {
            action: 'mgr/deltas/getlist',
            principal_package: config.principal_package,
            principal_class: config.principal_class,
            principal: config.principal,
            type: config.type,
        },
        params: [],
        fields: [
            {name: 'id', type: 'int'},
            {name: 'username', type: 'string'},
            {name: 'time_start', type: 'string'},
            {name: 'time_end', type: 'string'},
            {name: 'diffs', type: 'string'},
        ],
        paging: true,
        remoteSort: true,
        stripeRows: false,
        showActionsColumn: false,
        hideHeaders: true,
        autoExpandColumn: 'time_end',
        autoHeight: true,
        columns: [{
            header: 'Versions',//_('versionx.content_id',{what: _('resource')}),
            dataIndex: 'time_end',
            renderer: this.diffColumnRenderer
        },{
            header: 'Details',
            dataIndex: 'id',
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
    VersionX.grid.Deltas.superclass.constructor.call(this,config);
    this.config = config;
    this.on('click', this.handleClick, this);
};
Ext.extend(VersionX.grid.Deltas, MODx.grid.Grid, {
    search: function (tf, nv, ov) {
        let s = this.getStore();
        s.baseParams.query = tf.getValue();
        this.getBottomToolbar().changePage(1);
        this.refresh();
    },
    handleClick: function(e) {
        var t = e.getTarget(),
            className = t.className.split(' ')[0],
            that = this;

        switch (className) {
            case 'versionx-diff-revert-btn':
                // Confirm revert with user, and send request
                MODx.msg.confirm({
                    title: 'Confirm Revert',
                    text: 'Are you sure you want to revert to the before state of this change?',
                    url: VersionX.config.connector_url,
                    params: {
                        action: 'mgr/deltas/revert',
                        id: t.dataset.id,
                        principal: that.config['principal'],
                        type: that.config['type'],
                    },
                    listeners: {
                        'success': {fn: function() {
                                location.reload();
                            }, scope:this}
                    },
                });
            break;
        }
    },
    diffColumnRenderer: function(v, p, rec) {
        let diffs = rec.get('diffs'),
            version_id = rec.get('id'),
            name = rec.get('username'),
            time_end = rec.get('time_end');

        return `<div class="versionx-grid-diff-container">
                    <div class="versionx-grid-timeline">
                        <div class="versionx-grid-timeline-point"></div>
                    </div>
                    <div class="versionx-grid-column-diff">
                        <div class="versionx-diff-top-row">
                            <div class="versionx-diff-top-row-left">
                                <div class="versionx-diff-times">${time_end}</div>
                                <div class="versionx-diff-usernames">${name}</div>
                            </div>
                            <div class="versionx-diff-top-row-right">
                                <button class="versionx-diff-revert-btn x-button x-button-small primary-button" type="button" data-id="${version_id}">
                                    Revert
                                </button>
                                <div class="versionx-diff-menu"></div>
                            </div>
                        </div>
                        <div class="versionx-diff-list">
                            ${diffs}
                        </div>
                    </div>
                </div>`;
    },
    detailColumnRenderer: function(v, p, rec) {

    },
});
Ext.reg('versionx-grid-deltas', VersionX.grid.Deltas);


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
