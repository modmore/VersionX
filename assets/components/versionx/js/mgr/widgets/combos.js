VersionX.combo.VersionsList = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        hiddenName: config.name,
        displayField: 'display',
        valueField: 'id',
        fields: ['id','display'],
        url: VersionX.config.connector_url,
        baseParams: {
            action: 'mgr/'+config.name+'/get_versions'
        },
        typeAhead: true,
        editable: true,
        forceSelection: true,
        minChars: 1,
        pageSize: 20
    });
    VersionX.combo.VersionsList.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.combo.VersionsList,MODx.combo.ComboBox);


VersionX.combo.ChunkVersions = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        name: 'chunks'
    });
    VersionX.combo.ChunkVersions.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.combo.ChunkVersions,VersionX.combo.VersionsList);
Ext.reg('versionx-combo-chunkversions',VersionX.combo.ChunkVersions);

VersionX.combo.PluginVersions = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        name: 'plugins'
    });
    VersionX.combo.PluginVersions.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.combo.PluginVersions,VersionX.combo.VersionsList);
Ext.reg('versionx-combo-pluginversions',VersionX.combo.PluginVersions);

VersionX.combo.ResourceVersions = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        name: 'resources'
    });
    VersionX.combo.ResourceVersions.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.combo.ResourceVersions,VersionX.combo.VersionsList);
Ext.reg('versionx-combo-resourceversions',VersionX.combo.ResourceVersions);

VersionX.combo.SnippetVersions = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        name: 'snippets'
    });
    VersionX.combo.SnippetVersions.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.combo.SnippetVersions,VersionX.combo.VersionsList);
Ext.reg('versionx-combo-snippetversions',VersionX.combo.SnippetVersions);

VersionX.combo.TemplateVersions = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        name: 'templates'
    });
    VersionX.combo.TemplateVersions.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.combo.TemplateVersions,VersionX.combo.VersionsList);
Ext.reg('versionx-combo-templateversions',VersionX.combo.TemplateVersions);

VersionX.combo.TemplateVariableVersions = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        name: 'templatevars'
    });
    VersionX.combo.TemplateVariableVersions.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.combo.TemplateVariableVersions,VersionX.combo.VersionsList);
Ext.reg('versionx-combo-templatevarversions',VersionX.combo.TemplateVariableVersions);
