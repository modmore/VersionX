
Ext.applyIf(VersionX.panel, {ResourcesDetail:{}});
Ext.applyIf(VersionX.grid, {ResourcesDetail:{}});

Ext.onReady(function() {
    Ext.QuickTips.init();
    page = MODx.load({ xtype: 'versionx-page-resource'});
    page.show();
});

VersionX.page.Resource = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        renderTo: 'versionx',
        components: [{
            xtype: 'versionx-panel-header'
        },{
            xtype: 'versionx-panel-resourcesdetail',
            vxRecord: VersionX.record,
            vxRecordCmp: VersionX.cmrecord,
            border: false
        }],
        buttons: [{
            text: _('versionx.back'),
            handler: function () {
                window.location.href = '?a='+MODx.request['a'];
            }
        }]
    });
    VersionX.page.Resource.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.page.Resource,MODx.Component);
Ext.reg('versionx-page-resource',VersionX.page.Resource);

/*
Index page header configuration.
 */
VersionX.panel.Header = function(config) {
    config = config || {};
    Ext.apply(config,{
        border: false,
        baseCls: 'modx-formpanel',
        cls: 'modx-page-header',
        items: [{
            html: '<h2>'+_('versionx')+' '+_('versionx.resources.detail')+'</h2>',
            border: false
        },{
            html: '<p style="margin: 0 0 10px 3px;">'+_('versionx.resources.detail.text')+'</p>',
            border: false,
        },{
            border: false,
            style: "margin-bottom: 15px !important",
            layout: 'form',
            labelWidth: 175,
            items: [{
                xtype: 'versionx-combo-resourceversions',
                labelStyle: 'padding-top: 7px !important;',
                fieldLabel: _('versionx.compare_this_version_to'),
                name: 'compare_to',
                baseParams: {
                    resource: (VersionX.record) ? VersionX.record['content_id'] : 0,
                    current: (VersionX.record) ? VersionX.record['version_id'] : 0,
                    action: 'mgr/resources/get_versions'
                },
                listeners: {
                    'select': this.compareVersion
                }
            }]
        }]
    });
    VersionX.panel.Header.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.panel.Header,MODx.Panel,{
    compareVersion: function (tf, nv, ov) {
        cmid = tf.getValue();
        window.location.href = '?a='+MODx.request['a']+'&action=resource&vid='+MODx.request['vid']+'&cmid='+cmid;
    }
});
Ext.reg('versionx-panel-header',VersionX.panel.Header);



