Ext.onReady(function() {
    Ext.QuickTips.init();
    var page = MODx.load({ xtype: 'versionx-page-plugin'});
    page.show();
});

VersionX.page.Plugin = function(config) {
    config = config || {};
    config.type = 'plugin';
    VersionX.page.Plugin.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.page.Plugin,VersionX.page.Base);
Ext.reg('versionx-page-plugin',VersionX.page.Plugin);

