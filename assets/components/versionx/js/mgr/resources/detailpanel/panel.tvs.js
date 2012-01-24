Ext.ns('VersionX.panel.ResourcesDetail');
VersionX.panel.ResourcesDetail.TVs = function(config) {
    config = config || {};
    
    var data = [];
    for ( key in config.vxRecord.tvs ) {
        if ( typeof config.vxRecord.tvs[key].caption != 'undefined' ) {
            data.push([
                config.vxRecord.tvs[key].id,
                config.vxRecord.tvs[key].version,
                config.vxRecord.tvs[key].caption,
                config.vxRecord.tvs[key].value
            ]);
        }
    }
   
    Ext.apply(config,{
        items:[{
            layout: 'column',
            border: false,
            items: [{
                columnWidth: 1,
                xtype: 'versionx-grid-resourcesdetail-tvs',
                vxRecord: config.vxRecord,
                data: data
            }]
        }]
    });    
    
    if (config.vxRecordCmp) {
        var dataCmp = [];
        for ( key in config.vxRecordCmp.tvs ) {
            if ( typeof config.vxRecordCmp.tvs[key].caption != 'undefined' ) {
                dataCmp.push([
                config.vxRecordCmp.tvs[key].id,
                config.vxRecordCmp.tvs[key].version,
                config.vxRecordCmp.tvs[key].caption,
                config.vxRecordCmp.tvs[key].value
                ]);
            }
        }

        config.items[0].items[0].columnWidth = 0.5;
        config.items[0].items.push({
            columnWidth: .5,
            xtype: 'versionx-grid-resourcesdetail-tvs',
            vxRecord: config.vxRecordCmp,
            data: dataCmp
        });
        
    }
    
    VersionX.panel.ResourcesDetail.TVs.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.panel.ResourcesDetail.TVs,MODx.Panel,{});
Ext.reg('versionx-panel-resourcesdetail-tvs',VersionX.panel.ResourcesDetail.TVs);


Ext.ns('VersionX.grid.ResourcesDetail');
VersionX.grid.ResourcesDetail.TVs = function(config) {
    config = config || {};
    Ext.applyIf(config, {
        fields: [
            {name: 'tvID', type: 'string'},
            {name: 'tvVersion', type: 'string'},
            {name: 'tvName', type: 'string'},
            {name: 'tvValue', type: 'string'}
        ],
        columns: [
            {
                header: _('versionx.resources.detail.tvgrid.columns.tv-id'),
                dataIndex: 'tvID',
                sortable: true,
                width: .075
            },
            {
                header: _('versionx.resources.detail.tvgrid.columns.tv-version'),
                dataIndex: 'tvVersion',
                sortable: true,
                width: .075
            },
            {
                header: _('versionx.resources.detail.tvgrid.columns.tv-name'),
                dataIndex: 'tvName',
                sortable: true,
                width: .3
            },
            {
                header: _('versionx.resources.detail.tvgrid.columns.tv-value', {id:config.vxRecord.version_id}),
                dataIndex: 'tvValue',
                sortable: true,
                width: .5
            }
        ]
    })
    VersionX.grid.ResourcesDetail.TVs.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.grid.ResourcesDetail.TVs,VersionX.grid.Common.DetailGrid,{});
Ext.reg('versionx-grid-resourcesdetail-tvs',VersionX.grid.ResourcesDetail.TVs);

