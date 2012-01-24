Ext.ns('VersionX.grid.Common');

VersionX.grid.Common.DetailGrid = function(config) {
    config = config || {};
    Ext.apply(config,{
        autoHeight: true,
        width: '98%',
        viewConfig: {
            forceFit: true,
            enableRowBody: true
        },
        fields: [
            {name: 'fieldName', type: 'string'},
            {name: 'fieldValue', type: 'string'},
            {name: 'fieldValueCmp', type: 'string'}
        ],
        columns: [
            {
                header: _('versionx.resources.detail.grid.columns.field-name'),
                dataIndex: 'fieldName',
                sortable: true,
                width: .25
            },
            {
                header: _('versionx.resources.detail.grid.columns.field-value', {id:config.vxRecord.version_id}),
                dataIndex: 'fieldValue',
                sortable: true,
                width: .375
            }
        ]
    });

    // Populate data
    if ( typeof config.vxFieldMap != 'undefined' ) {
        config.data = [];
        
        var length = config.vxFieldMap.length;
        for ( var i = 0; i < length; i++ ) {
            if (config.vxFieldMap[i].enumerate) {
                config.data.push([
                    _(config.vxFieldMap[i].lexicon),
                    '<pre>'+JSON.stringify(config.vxRecord[config.vxFieldMap[i].key], null, 2) + '</pre>',
                    config.vxRecordCmp ? '<pre>'+JSON.stringify(config.vxRecordCmp[config.vxFieldMap[i].key], null, 2) + '</pre>' : ''
                ]);
            } else {
                config.data.push([
                    _(config.vxFieldMap[i].lexicon),
                    config.vxRecord[config.vxFieldMap[i].key],
                    config.vxRecordCmp ? config.vxRecordCmp[config.vxFieldMap[i].key] : ''
                ]);
            }
        }
    }

    if ( config.vxRecordCmp ) {
        config.columns.push({
            header: _('versionx.resources.detail.grid.columns.field-value', {id:config.vxRecordCmp.version_id}),
            dataIndex: 'fieldValueCmp',
            sortable: true,
            width: .375
        });
    }

    VersionX.grid.Common.DetailGrid.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.grid.Common.DetailGrid,MODx.grid.LocalGrid,{});
Ext.reg('versionx-grid-common-detailgrid',VersionX.grid.Common.DetailGrid);
