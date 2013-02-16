Ext.onReady(function() {
    Ext.QuickTips.init();
    var page = MODx.load({ xtype: 'versionx-page-template'});
    page.show();
});

VersionX.page.Template = function(config) {
    config = config || {};
    config.type = 'template';
    VersionX.page.Template.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.page.Template,VersionX.page.Base);
Ext.reg('versionx-page-template',VersionX.page.Template);

