VersionX.panel.ResourcesDetail.TVs = function(config) {
    config = config || {};
    
    var vxTemplateVars = [];    
    for ( key in config.vxRecord.tvs ) {
        var id = config.vxRecord.tvs[key].id;
        if ( ! vxTemplateVars[id] ) {
            vxTemplateVars[id] = config.vxRecord.tvs[key];
        }
    }
    if ( config.vxRecordCmp ) {
        for ( key in config.vxRecordCmp.tvs ) {
            var id = config.vxRecordCmp.tvs[key].id;
            if ( ! vxTemplateVars[id] ) {
                vxTemplateVars[id] = config.vxRecordCmp.tvs[key];
                vxTemplateVars[id].value = ''; 
            }
            vxTemplateVars[id].cm_value = config.vxRecordCmp.tvs[key].value;
        }
    }
    
    var data = [];
    for ( key in vxTemplateVars ) {
        if ( typeof vxTemplateVars[key].caption != 'undefined' ) {
            data.push([
                vxTemplateVars[key].caption,
                vxTemplateVars[key].value,
                vxTemplateVars[key].cm_value
            ]);
        }
    }
    
    Ext.apply(config,{
        items: [{
            xtype: 'versionx-grid-common-detailgrid',
            vxRecord: config.vxRecord,
            vxRecordCmp: config.vxRecordCmp ? config.vxRecordCmp : undefined,
            data: data
        }]
    });    
    VersionX.panel.ResourcesDetail.TVs.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.panel.ResourcesDetail.TVs,MODx.Panel,{});
Ext.reg('versionx-panel-resourcesdetail-tvs',VersionX.panel.ResourcesDetail.TVs);
