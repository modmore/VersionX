VersionX.combo.PluginVersions = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        name: 'plugins',
        hiddenName: 'plugins',
        displayField: 'display',
        valueField: 'id',
        fields: ['id','display'],
        url: VersionX.config.connector_url,
        baseParams: {
            action: 'mgr/plugins/get_versions'
        },
        typeAhead: true,
        editable: true,
        forceSelection: true,
        minChars: 1,
        pageSize: 20
    });
    VersionX.combo.PluginVersions.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.combo.PluginVersions,MODx.combo.ComboBox);
Ext.reg('versionx-combo-pluginversions',VersionX.combo.PluginVersions);
