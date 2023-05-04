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
        filters: ['query', 'date_from', 'date_to', 'editor'],
        fields: [
            {name: 'id', type: 'int'},
            {name: 'username', type: 'string'},
            {name: 'milestone', type: 'string'},
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
        pageSize: 10,
        columns: [{
            header: 'Versions',
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
            xtype: 'versionx-combo-editors',
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
            text: '<i class="icon icon-minus"></i>',
            handler: this.clearFilters,
        }]
    });
    VersionX.grid.Deltas.superclass.constructor.call(this,config);
    this.config = config;
    this.on('click', this.handleClick, this);
};
Ext.extend(VersionX.grid.Deltas, MODx.grid.Grid, {
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
    addMilestone: function(deltaId) {
        if (this.addMilestoneWindow) {
            this.addMilestoneWindow.destroy();
        }

        this.addMilestoneWindow = MODx.load({
            xtype: 'versionx-window-milestone',
            delta_id: deltaId,
            listeners: {
                'success': {fn: this.refresh, scope: this}
            }
        });
        this.addMilestoneWindow.show();
    },
    handleClick: function(e) {
        var t = e.getTarget(),
            className = t.className.split(' ')[0],
            that = this;

        switch (className) {
            case 'versionx-diff-milestone-btn':
                if (t.dataset.milestone.length > 0) {
                    MODx.msg.confirm({
                        title: 'Confirm Milestone Removal',
                        text: 'Are you sure you want to remove the milestone tag? Doing so means this delta will be included in the next merge.',
                        url: VersionX.config.connector_url,
                        params: {
                            action: 'mgr/deltas/milestone',
                            delta_id: t.dataset.id,
                            what: 'remove',
                        },
                        listeners: {
                            'success': {fn: function() {
                                    that.refresh();
                                }, scope:this}
                        },
                    });
                    break;
                }

                // Open create milestone window
                that.addMilestone(t.dataset.id);

                break;

            case 'versionx-field-diff-undo-btn-' + t.dataset.field_id:
                MODx.msg.confirm({
                    title: 'Confirm Undo',
                    text: 'Are you sure you want to undo this change?',
                    url: VersionX.config.connector_url,
                    params: {
                        action: 'mgr/deltas/revert',
                        field_id: t.dataset.field_id,
                        delta_id: t.dataset.delta_id,
                        what: 'revert_field',
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

            case 'versionx-diff-revert-btn':
                MODx.msg.confirm({
                    title: 'Confirm Revert',
                    text: 'Are you sure you want to revert all changes in this delta?',
                    url: VersionX.config.connector_url,
                    params: {
                        action: 'mgr/deltas/revert',
                        delta_id: t.dataset.id,
                        what: 'revert_delta',
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

            case 'versionx-diff-revert-all-btn':
                let time = Ext.util.Format.date(t.dataset.time_start,
                    `${MODx.config.manager_date_format} H:i:s`)
                MODx.msg.confirm({
                    title: 'Revert All Fields to ' + time,
                    text: `<p>Are you sure you want to revert all fields to this point in time?
                               <strong>${time}</strong>
                           </p>`,
                    url: VersionX.config.connector_url,
                    params: {
                        action: 'mgr/deltas/revert',
                        delta_id: t.dataset.id,
                        what: 'revert_all',
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
            time_start = rec.get('time_start'),
            time_end = rec.get('time_end'),
            milestone = rec.get('milestone');

        // If we've got a milestone, set a class for it so it can be rendered differently
        let milestone_class = '';
        if (milestone) {
            milestone_class = ' milestone';
        }

        return `<div class="versionx-grid-diff-container">
                    <div class="versionx-grid-timeline">
                        <div class="versionx-grid-timeline-point"></div>
                    </div>
                    <div class="versionx-grid-main-col">
                        <button 
                            class="versionx-diff-revert-all-btn x-button x-button-small primary-button" 
                            type="button" 
                            data-time_start="${time_start}" 
                            data-id="${version_id}"
                        >
                            <i class="icon icon-undo"></i> &nbsp;&nbsp;Revert all fields to this point in time
                        </button>
                        <div class="versionx-grid-column-diff">
                            <div class="versionx-diff-top-row">
                                <div class="versionx-diff-top-row-left">
                                    <div class="versionx-diff-times">${time_end}</div>
                                    <div class="versionx-diff-usernames">${name}</div>
                                </div>
                                <div class="versionx-diff-top-row-right">
                                    <button 
                                        title="Edit milestone"
                                        class="versionx-diff-milestone-btn${milestone_class} x-button x-button-small" 
                                        type="button" 
                                        data-id="${version_id}"
                                        data-milestone="${milestone}"
                                    >
                                        <i class="icon icon-flag"></i>
                                    </button>
                                    <button 
                                        class="versionx-diff-revert-btn x-button x-button-small primary-button" 
                                        type="button" 
                                        data-id="${version_id}"
                                    >
                                        Revert these changes
                                    </button>
                                </div>
                            </div>
                            <div class="versionx-diff-list">
                                ${diffs}
                            </div>
                        </div>
                    </div>
                </div>`;
    },
});
Ext.reg('versionx-grid-deltas', VersionX.grid.Deltas);
