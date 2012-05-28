VersionX.combo.ChunkVersions = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        name: 'chunks',
        hiddenName: 'chunks',
        displayField: 'display',
        valueField: 'id',
        fields: ['id','display'],
        url: VersionX.config.connector_url,
        baseParams: {
            action: 'mgr/chunks/get_versions'
        },
        typeAhead: true,
        editable: true,
        forceSelection: true,
        minChars: 1,
        pageSize: 20
    });
    VersionX.combo.ChunkVersions.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.combo.ChunkVersions,MODx.combo.ComboBox);
Ext.reg('versionx-combo-chunkversions',VersionX.combo.ChunkVersions);
