var VersionX = function(config) {
    config = config || {};
    VersionX.superclass.constructor.call(this,config);
};
Ext.extend(VersionX,Ext.Component,{
    page:{},window:{},grid:{},tree:{},panel:{},combo:{},config: {}
});
Ext.reg('versionx',VersionX);
VersionX = new VersionX();