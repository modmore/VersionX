Ext.onReady(function() {
    Ext.QuickTips.init();
    page = MODx.load({ xtype: 'versionx-page-resource'});
    if (VersionX.record) {
        Ext.getCmp('versionx-panel-resourcesdetail').getForm().setValues(VersionX.record);

        for (i in VersionX.record.tvs) {
            tv = VersionX.record.tvs[i];
            if (typeof tv == 'object') {
                Ext.getCmp('versionx-resource-tvs').add({xtype: 'statictextfield', fieldLabel: tv['caption'], value: tv['value'], id: 'vx-tv-'+tv['id'] })
            }
        }
        Ext.getCmp('versionx-resource-tvs').doLayout();
    }
    if (VersionX.cmrecord) {
        Ext.getCmp('versionx-panel-resourcesdetail').getForm().setValues(VersionX.cmrecord);

        for (key in VersionX.cmrecord) {
            if (!(key in {'cm_tvs':'', 'cm_fields':'', 'cm_content':'', 'cm_saved':'', 'cm_version_id':'', 'cm_editedon':'' })) {
                keyVersion = key.substring(3);
                left = VersionX.record[keyVersion];
                right = VersionX.cmrecord[key];
                /* Added to version on the left */
                if (left != right) {
                    leftObj = Ext.getCmp('vx-' + keyVersion);
                    if (typeof leftObj != 'undefined') {
                        if (left.length < 1) leftObj.getItemCt().addClass('vx-removed');
                        else if (right.length < 1) leftObj.getItemCt().addClass('vx-added');
                        else leftObj.getItemCt().addClass('vx-changed');
                    }
                }
            }
        }

        for (i in VersionX.cmrecord.cm_tvs) {
            tv = VersionX.cmrecord.cm_tvs[i];
            if (typeof tv == 'object') {
                Ext.getCmp('versionx-resource-cm-tvs').add({xtype: 'statictextfield', fieldLabel: tv['caption'], value: tv['value']})
                leftTv = Ext.getCmp('vx-tv-'+tv['id']);
                if (typeof leftTv != 'undefined') {
                    if (leftTv.value != tv['value']) {
                        if (leftTv.length < 1) leftTv.getItemCt().addClass('vx-removed');
                        else if (tv['value'].length < 1) leftTv.getItemCt().addClass('vx-added');
                        else leftTv.getItemCt().addClass('vx-changed');
                    }
                }
            }
        }
        Ext.getCmp('versionx-resource-cm-tvs').doLayout();
    }
    page.show();
});

VersionX.page.Resource = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        renderTo: 'versionx',
        components: [{
            xtype: 'versionx-panel-header'
        },{
            xtype: 'modx-tabs',
            width: '98%',
            bodyStyle: 'padding: 10px 10px 10px 10px;',
            border: true,
            defaults: {
                border: false,
                autoHeight: true,
                bodyStyle: 'padding: 5px 8px 5px 5px;'
            },
            items: [{
                title: _('versionx.resources.detail'),
                items: [{
                    xtype: 'versionx-panel-resourcesdetail',
                    border: false
                }]
            }]
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
        border: false
        ,baseCls: 'modx-formpanel'
        ,items: [{
            html: '<h2>'+_('versionx')+' '+_('versionx.resources.detail')+'</h2>'
            ,border: false
            ,cls: 'modx-page-header'
        }]
    });
    VersionX.panel.Header.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.panel.Header,MODx.Panel);
Ext.reg('versionx-panel-header',VersionX.panel.Header);



