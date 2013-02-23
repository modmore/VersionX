var VersionX = function(config) {
    config = config || {};
    VersionX.superclass.constructor.call(this,config);
};
Ext.extend(VersionX,Ext.Component,{
    page:{},window:{},grid:{},tree:{},panel:{},tabs:{},combo:{},
    config: {
        connector_url: ''
    },
    inVersion: false
});
Ext.reg('versionx',VersionX);
VersionX = new VersionX();

Ext.onReady(function() {
    Ext.QuickTips.init();
});
