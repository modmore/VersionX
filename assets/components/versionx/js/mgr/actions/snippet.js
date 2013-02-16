Ext.onReady(function() {
    Ext.QuickTips.init();
    var page = MODx.load({ xtype: 'versionx-page-snippet'});
    page.show();
});

VersionX.page.Snippet = function(config) {
    config = config || {};
    config.type = 'snippet';
    VersionX.page.Snippet.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.page.Snippet,VersionX.page.Base);
Ext.reg('versionx-page-snippet',VersionX.page.Snippet);

