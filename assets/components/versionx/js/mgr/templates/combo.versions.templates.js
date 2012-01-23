VersionX.combo.TemplateVersions = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        name: 'templates',
        hiddenName: 'templates',
        displayField: 'display',
        valueField: 'id',
        fields: ['id','display'],
        url: VersionX.config.connector_url,
        baseParams: {
            action: 'mgr/templates/get_versions'
        },
        typeAhead: true,
        editable: true,
        forceSelection: true,
        minChars: 1,
        pageSize: 20
    });
    VersionX.combo.TemplateVersions.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.combo.TemplateVersions,MODx.combo.ComboBox);
Ext.reg('versionx-combo-templateversions',VersionX.combo.TemplateVersions);