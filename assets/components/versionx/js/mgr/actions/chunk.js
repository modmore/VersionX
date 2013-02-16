Ext.onReady(function() {
    Ext.QuickTips.init();
    var page = MODx.load({ xtype: 'versionx-page-chunk'});
    page.show();
});

VersionX.page.Chunk = function(config) {
    config = config || {};
    config.type = 'chunk';
    VersionX.page.Chunk.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.page.Chunk,VersionX.page.Base);
Ext.reg('versionx-page-chunk',VersionX.page.Chunk);

