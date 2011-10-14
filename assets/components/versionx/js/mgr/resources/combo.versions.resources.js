VersionX.combo.ResourceVersions = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        name: 'subscribers',
        hiddenName: 'subscribers',
        displayField: 'display',
        valueField: 'id',
        fields: ['id','display'],
        url: VersionX.config.connector_url,
        baseParams: {
            action: 'mgr/resources/get_versions'
        },
        typeAhead: true,
        editable: true,
        forceSelection: true,
        minChars: 1,
        pageSize: 20
    });
    VersionX.combo.ResourceVersions.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.combo.ResourceVersions,MODx.combo.ComboBox);
Ext.reg('versionx-combo-resourceversions',VersionX.combo.ResourceVersions);