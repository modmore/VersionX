VersionX.combo.SnippetVersions = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        name: 'snippets',
        hiddenName: 'snippets',
        displayField: 'display',
        valueField: 'id',
        fields: ['id','display'],
        url: VersionX.config.connector_url,
        baseParams: {
            action: 'mgr/snippets/get_versions'
        },
        typeAhead: true,
        editable: true,
        forceSelection: true,
        minChars: 1,
        pageSize: 20
    });
    VersionX.combo.SnippetVersions.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.combo.SnippetVersions,MODx.combo.ComboBox);
Ext.reg('versionx-combo-snippetversions',VersionX.combo.SnippetVersions);
