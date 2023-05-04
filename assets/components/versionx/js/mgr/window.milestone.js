VersionX.window.Milestone = function(config) {
    config = config || {};
    var win = this;
    Ext.applyIf(config, {
        title: 'Create Milestone',
        url: VersionX.config.connector_url,
        baseParams: {
            action: 'mgr/deltas/milestone',
            delta_id: config.delta_id,
            what: 'add',
        },
        cls: 'versionx-milestone-window',
        tbar: [{
            xtype: 'tbtext',
            html: 'Milestone deltas are preserved and won\'t be merged with other deltas'
        }],
        fields: [{
            xtype: 'textfield',
            fieldLabel: 'Milestone name',
            name: 'milestone',
            anchor: '1'
        },{
            xtype: 'label',
            cls: 'desc-under',
            text: 'Add a name for this milestone delta'
        }],
    });
    VersionX.window.Milestone.superclass.constructor.call(this, config);
}
Ext.extend(VersionX.window.Milestone, MODx.Window);
Ext.reg('versionx-window-milestone', VersionX.window.Milestone);