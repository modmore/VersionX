Ext.onReady(function() {
    Ext.QuickTips.init();
    var page = MODx.load({ xtype: 'versionx-page-templatevar'});
    page.show();
});

VersionX.page.TemplateVar = function(config) {
    config = config || {};
    config.type = 'templatevar';
    VersionX.page.TemplateVar.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.page.TemplateVar,VersionX.page.Base);
Ext.reg('versionx-page-templatevar',VersionX.page.TemplateVar);

