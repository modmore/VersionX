
VersionX.panel.Home = function(config) {
    config = config || {};
    Ext.apply(config,{
        id: 'versionx-panel-ome',
        border: false,
        forceLayout: true,
        baseCls: 'modx-formpanel',
        width: '98%',
        items: [{
            html: '<p>'+_('versionx.home.text')+'</p>'
        }]
    });
    VersionX.panel.Home.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.panel.Home,MODx.FormPanel);
Ext.reg('versionx-panel-home',VersionX.panel.Home);