VersionX.combo.TemplateVariableVersions = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        name: 'templatevars',
        hiddenName: 'templatevars',
        displayField: 'display',
        valueField: 'id',
        fields: ['id','display'],
        url: VersionX.config.connector_url,
        baseParams: {
            action: 'mgr/templatevars/get_versions'
        },
        typeAhead: true,
        editable: true,
        forceSelection: true,
        minChars: 1,
        pageSize: 20
    });
    VersionX.combo.TemplateVariableVersions.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.combo.TemplateVariableVersions,MODx.combo.ComboBox);
Ext.reg('versionx-combo-templatevarversions',VersionX.combo.TemplateVariableVersions);