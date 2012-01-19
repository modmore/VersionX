VersionX.panel.ResourcesDetail.Main = function(config) {
    config = config || {};
    Ext.apply(config,{
        id: 'versionx-panel-resourcesdetail',
        border: false,
        forceLayout: true,
        width: '98%',
        layout: 'form',
        items: [{
            xtype: 'modx-tabs',
            width: '98%',
            border: true,
            defaults: {
                border: false,
                autoHeight: true,
                bodyStyle: 'padding: 10px 10px 10px 10px;',
            },
            items: [
                {
                    title: _('versionx.resources.detail.tabs.version-details'),
                    items: [{
                        id: 'versionx-panel-resourcesdetail-versioninfo',
                        xtype: 'versionx-panel-resourcesdetail-common',
                        border: false,
                        vxRecord: config.vxRecord,
                        vxRecordCmp: config.vxRecordCmp ? config.vxRecordCmp : undefined,
                        vxFieldMap: [
                            { key: 'version_id', lexicon:'versionx.version_id' },
                            { key: 'user', lexicon:'user' },
                            { key: 'saved', lexicon:'versionx.saved' },
                            { key: 'mode', lexicon:'versionx.mode' },
                        ]
                    }]
                },
                {
                    title: _('versionx.resources.detail.tabs.resource-fields'),
                    items: [{
                        id: 'versionx-panel-resourcesdetail-resource-fields',
                        xtype: 'versionx-panel-resourcesdetail-common',
                        border: false,
                        vxRecord: config.vxRecord,
                        vxRecordCmp: config.vxRecordCmp ? config.vxRecordCmp : undefined,
                        vxFieldMap: [
                            { key: 'pagetitle', lexicon:'resource_pagetitle' },
                            { key: 'longtitle', lexicon:'resource_longtitle' },
                            { key: 'description', lexicon:'resource_description' },
                            { key: 'alias', lexicon:'resource_alias' },
                            { key: 'link_attributes', lexicon:'resource_link_attributes' },
                            { key: 'summary', lexicon:'resource_summary' },
                            { key: 'parent', lexicon:'resource_parent' },
                            { key: 'menutitle', lexicon:'resource_menutitle' },
                            { key: 'menuindex', lexicon:'resource_menuindex' },
                            { key: 'published', lexicon:'resource_published' },
                            { key: 'hidemenu', lexicon:'resource_hide_from_menus' },
                        ]
                    }]
                },
                {
                    title: _('versionx.resources.detail.tabs.resource-content'),
                    items: [{
                        id: 'versionx-panel-resourcesdetail-content',
                        xtype: 'versionx-panel-resourcesdetail-content',
                        border: false,
                        vxRecord: config.vxRecord,
                        vxRecordCmp: config.vxRecordCmp ? config.vxRecordCmp : undefined
                    }]
                },
                {
                    title: _('versionx.resources.detail.tabs.template-variables'),
                    // If this tab contains vertical tabs, enable this ---> bodyStyle: 'padding: 0 !important;',
                    items: [{
                        id: 'versionx-panel-resourcesdetail-tvs',
                        xtype: 'versionx-panel-resourcesdetail-tvs',
                        border: false,
                        vxRecord: config.vxRecord,
                        vxRecordCmp: config.vxRecordCmp ? config.vxRecordCmp : undefined
                    }]
                },
                {
                    title: _('versionx.resources.detail.tabs.page-settings'),
                    items: [{
                        id: 'versionx-panel-resourcesdetail-page-settings',
                        xtype: 'versionx-panel-resourcesdetail-common',
                        border: false,
                        vxRecord: config.vxRecord,
                        vxRecordCmp: config.vxRecordCmp ? config.vxRecordCmp : undefined,
                        vxFieldMap: [
                            { key: 'isfolder', lexicon:'resource_folder' },
                            { key: 'richtext', lexicon:'resource_richtext' },
                            { key: 'publsihedon', lexicon:'resource_publishedon' },
                            { key: 'pub_date', lexicon:'resource_publishdate' },
                            { key: 'unpub_date', lexicon:'resource_unpublishdate' },
                            { key: 'searchable', lexicon:'resource_searchable' },
                            { key: 'cacheable', lexicon:'resource_cacheable' },
                            { key: 'deleted', lexicon:'deleted' },
                            { key: 'content_type', lexicon:'resource_content_type' },
                            { key: 'content_dispo', lexicon:'resource_contentdispo' },
                            { key: 'class_key', lexicon:'class_key' },
                        ]
                    }]
                }
            ]
        }],
        listeners: {
        }
    });
    VersionX.panel.ResourcesDetail.Main.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.panel.ResourcesDetail.Main,MODx.FormPanel,{});
Ext.reg('versionx-panel-resourcesdetail',VersionX.panel.ResourcesDetail.Main);
