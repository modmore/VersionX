Ext.ns('VersionX.panel.TemplateVariablesDetail');

VersionX.panel.TemplateVariablesDetail.Main = function(config) {
    config = config || {};
    Ext.apply(config,{
        id: 'versionx-panel-templatevarsdetail',
        border: false,
        layout: 'form',
        items: [{
            html: '<p>'+_('versionx.common.detail.text',{what:_('tmplvar')})+'</p>',
            border: false,
            bodyCssClass: 'panel-desc'
        },{
            layout: 'form',
            cls: 'main-wrapper',
            labelWidth: 125,
            items: [{
                xtype: 'versionx-combo-templatevarversions',
                fieldLabel: _('versionx.compare_to'),
                labelStyle: 'padding: 7px 0 0 5px;',
                name: 'compare_to',
                baseParams: {
                    templatevar: (VersionX.record) ? VersionX.record['content_id'] : 0,
                    current: (VersionX.record) ? VersionX.record['version_id'] : 0,
                    action: 'mgr/templatevars/get_versions'
                },
                listeners: {
                    'select': this.compareVersion
                }
            },{
                xtype: 'panel',
                bodyStyle: 'height: 12px',
                border: false
            },{
                xtype: 'modx-tabs',
                bodyStyle: 'padding: 15px;',
                width: '98%',
                border: true,
                defaults: {
                    border: false,
                    autoHeight: true,
                    defaults: {
                        border: false
                    }
                },
                items: [{
                    title: _('versionx.common.version-details'),
                    items: [{
                        id: 'versionx-panel-templatevarsdetail-versioninfo',
                        xtype: 'versionx-panel-common-detailpanel',
                        vxRecord: config.vxRecord,
                        vxRecordCmp: config.vxRecordCmp ? config.vxRecordCmp : undefined,
                        vxFieldMap: [
                            { key: 'version_id', lexicon:'versionx.version_id' },
                            { key: 'user', lexicon:'user' },
                            { key: 'saved', lexicon:'versionx.saved' },
                            { key: 'mode', lexicon:'versionx.mode' }
                        ]
                    }]
                },{
                    title: _('general_information'),
                    items: [{
                        id: 'versionx-panel-templatevarsdetail-generalinformation',
                        xtype: 'versionx-panel-common-detailpanel',
                        vxRecord: config.vxRecord,
                        vxRecordCmp: config.vxRecordCmp ? config.vxRecordCmp : undefined,
                        vxFieldMap: [
                            { key: 'name', lexicon:'name' },
                            { key: 'category', lexicon:'category' },
                            { key: 'caption', lexicon:'caption' },
                            { key: 'description', lexicon:'description' },
                            { key: 'rank', lexicon:'rank' },
                            { key: 'locked', lexicon:'locked' }
                        ]
                    }]
                },{
                    title: _('versionx.templatevars.detail.tabs.properties'),
                    tabTip: _('versionx.templatevars.detail.tabs.properties.off'),
                    items: [],
                    disabled: true
                },{
                    title: _('versionx.templatevars.detail.tabs.input-options'),
                    items: [{
                        id: 'versionx-panel-templatevarsdetail-inputoptions',
                        xtype: 'versionx-panel-common-detailpanel',
                        vxRecord: config.vxRecord,
                        vxRecordCmp: config.vxRecordCmp ? config.vxRecordCmp : undefined,
                        vxFieldMap: [
                            { key: 'type', lexicon:'versionx.templatevars.detail.input-type' },
                            { key: 'default_text', lexicon:'versionx.templatevars.detail.default-text' },
                            { key: 'input_properties', lexicon:'versionx.templatevars.detail.input-properties', enumerate:true }
                        ]
                    }]
                },{
                    title: _('versionx.templatevars.detail.tabs.output-options'),
                    items: [{
                        id: 'versionx-panel-templatevarsdetail-outputoptions',
                        xtype: 'versionx-panel-common-detailpanel',
                        vxRecord: config.vxRecord,
                        vxRecordCmp: config.vxRecordCmp ? config.vxRecordCmp : undefined,
                        vxFieldMap: [
                            { key: 'display', lexicon:'versionx.templatevars.detail.output-type' },
                            { key: 'output_properties', lexicon:'versionx.templatevars.detail.output-properties', enumerate:true }
                        ]
                    }]
                }]
            }]
        }],
        listeners: {
        }
    });
    VersionX.panel.TemplateVariablesDetail.Main.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.panel.TemplateVariablesDetail.Main,MODx.FormPanel,{
    compareVersion: function (tf) {
        var cmid = tf.getValue();
        var backTo = (MODx.request.backTo) ? '&backTo='+MODx.request.backTo : '';
        window.location.href = '?a='+VersionX.action+'&action=templatevar&vid='+MODx.request['vid']+'&cmid='+cmid+backTo;
    }
});
Ext.reg('versionx-panel-templatevarsdetail',VersionX.panel.TemplateVariablesDetail.Main);
