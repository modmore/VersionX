var VersionX = function (config) {
    config = config || {};
    VersionX.superclass.constructor.call(this, config);
};
Ext.extend(VersionX, Ext.Component, {
    page: {}, window: {}, grid: {ResourcesDetail: {},TemplatesDetail:{}}, tree: {}, panel: {ResourcesDetail: {},TemplatesDetail:{}}, tabs: {}, combo: {},
    config: {
        connector_url: ''
    },
    inVersion: false
});
Ext.reg('versionx', VersionX);
VersionX = new VersionX();

VersionX.panel.VersionHeader = function (config) {
    config = config || {};
    config.title = config.title || 'New Section';
    Ext.apply(config, {
        border: false,
        forceLayout: true,
        width: '98%',
        items: [{
            html: '<h3 style="border-bottom: 1px solid; padding-top: 1em;">' + config.title + '</h3>'
        }]
    });
    VersionX.panel.VersionHeader.superclass.constructor.call(this, config);
};
Ext.extend(VersionX.panel.VersionHeader, MODx.Panel);
Ext.reg('versionx-panel-versionheader', VersionX.panel.VersionHeader);
