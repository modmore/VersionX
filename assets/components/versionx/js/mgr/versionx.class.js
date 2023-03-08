var VersionX = function (config) {
    config = config || {};
    VersionX.superclass.constructor.call(this, config);
};
Ext.extend(VersionX, Ext.Component, {
    page: {},
    window: {},
    grid: {},
    tree: {},
    panel: {},
    combo: {},
    field: {},
    config: {},
    stats: {},
    inVersion: false,
});
Ext.reg('versionx', VersionX);
VersionX = new VersionX();

VersionX.panel.VersionHeader = function (config) {
    config = config || {};
    config.title = config.title || 'New Section';
    Ext.apply(config, {
        border: false,
        forceLayout: true,
        items: [{
            html: '<h3 style="border-bottom: 1px solid; padding-top: 1em;">' + config.title + '</h3>'
        }]
    });
    VersionX.panel.VersionHeader.superclass.constructor.call(this, config);
};
Ext.extend(VersionX.panel.VersionHeader, MODx.Panel);
Ext.reg('versionx-panel-versionheader', VersionX.panel.VersionHeader);

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