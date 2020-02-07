VersionX.panel.ResourcesDetail.Main = function(config) {
    config = config || {};
    config.id = config.id || 'versionx-panel-resourcesdetail';
    Ext.apply(config,{
        border: false,
        layout: 'form',
        items: [{
            html: '<p>'+_('versionx.resources.detail.text')+'</p>',
            border: false,
            bodyCssClass: 'panel-desc'
        },{
            layout: 'form',
            cls: 'main-wrapper',
            items: [{
                layout: 'hbox',
                border: false,
                items: [{
                    xtype: 'versionx-combo-resourceversions',
                    emptyText: _('versionx.compare_to'),
                    labelStyle: 'padding: 7px 0 0 5px;',
                    width: 300,
                    name: 'compare_to',
                    baseParams: {
                        content_id: (VersionX.record) ? VersionX.record['content_id'] : 0,
                        current: (VersionX.record) ? VersionX.record['version_id'] : 0,
                        action: 'mgr/resources/get_versions'
                    },
                    listeners: {
                        'select': this.compareVersion
                    }
                },{html: '&nbsp;', border: false, bodyStyle: 'margin-left: 10px;'},{
                    xtype: 'button',
                    cls: 'primary-button',
                    text: _('versionx.resources.revert.options'),
                    handler: (VersionX.record && VersionX.cmrecord) ? Ext.emptyFn : function() {
                        this.revertVersion((VersionX.record) ? VersionX.record['version_id'] : 0);
                    },
                    scope: this,
                    menu: (VersionX.record && VersionX.cmrecord) ?
                        [{
                            text: _('versionx.resources.revert',{id: VersionX.record['version_id']}),
                            handler: function() {
                                this.revertVersion((VersionX.record) ? VersionX.record['version_id'] : 0);
                            },
                            scope: this
                        },{
                            text: _('versionx.resources.revert',{id: VersionX.cmrecord['version_id']}),
                            handler: function() {
                                this.revertVersion((VersionX.cmrecord) ? VersionX.cmrecord['version_id'] : 0);
                            },
                            scope: this
                        }] : undefined
                }]
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
                        id: 'versionx-panel-resourcesdetail-versioninfo',
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
                    title: _('versionx.common.fields'),
                    items: [{
                        id: 'versionx-panel-resourcesdetail-resource-fields',
                        xtype: 'versionx-panel-common-detailpanel',
                        vxRecord: config.vxRecord,
                        vxRecordCmp: config.vxRecordCmp ? config.vxRecordCmp : undefined,
                        vxFieldMap: [
                            { key: 'pagetitle', lexicon:'resource_pagetitle' },
                            { key: 'longtitle', lexicon:'resource_longtitle' },
                            { key: 'template', lexicon:'template' },
                            { key: 'description', lexicon:'resource_description' },
                            { key: 'alias', lexicon:'resource_alias' },
                            { key: 'link_attributes', lexicon:'resource_link_attributes' },
                            { key: 'introtext', lexicon:'resource_summary' },
                            { key: 'parent', lexicon:'resource_parent' },
                            { key: 'menutitle', lexicon:'resource_menutitle' },
                            { key: 'menuindex', lexicon:'resource_menuindex' },
                            { key: 'published', lexicon:'resource_published' },
                            { key: 'hidemenu', lexicon:'resource_hide_from_menus' }
                        ]
                    }]
                },{
                    title: _('versionx.common.content'),
                    items: [{
                        id: 'versionx-panel-resourcesdetail-content',
                        xtype: 'versionx-panel-common-contentpanel',
                        border: false,
                        vxRecord: config.vxRecord,
                        vxRecordCmp: config.vxRecordCmp ? config.vxRecordCmp : undefined,
                        vxContentField: 'content'
                    }]
                },{
                    title: _('versionx.resources.detail.tabs.template-variables'),
                    items: [{
                        id: 'versionx-panel-resourcesdetail-tvs',
                        xtype: 'versionx-panel-resourcesdetail-tvs',
                        border: false,
                        vxRecord: config.vxRecord,
                        vxRecordCmp: config.vxRecordCmp ? config.vxRecordCmp : undefined
                    }]
                },{
                    title: _('versionx.resources.detail.tabs.page-settings'),
                    items: [{
                        id: 'versionx-panel-resourcesdetail-page-settings',
                        xtype: 'versionx-panel-common-detailpanel',
                        border: false,
                        vxRecord: config.vxRecord,
                        vxRecordCmp: config.vxRecordCmp ? config.vxRecordCmp : undefined,
                        vxFieldMap: [
                            { key: 'isfolder', lexicon:'resource_folder' },
                            { key: 'richtext', lexicon:'resource_richtext' },
                            { key: 'publishedon', lexicon:'resource_publishedon' },
                            { key: 'pub_date', lexicon:'resource_publishdate' },
                            { key: 'unpub_date', lexicon:'resource_unpublishdate' },
                            { key: 'searchable', lexicon:'resource_searchable' },
                            { key: 'cacheable', lexicon:'resource_cacheable' },
                            { key: 'deleted', lexicon:'deleted' },
                            { key: 'content_type', lexicon:'resource_content_type' },
                            { key: 'content_dispo', lexicon:'resource_contentdispo' },
                            { key: 'class_key', lexicon:'class_key' }
                        ]
                    }]
                }],
                stateful: true,
                stateId: config.id,
                stateEvents: ['tabchange'],
                getState: function() {
                    return { activeTab:this.items.indexOf(this.getActiveTab()) };
                }
            }]
        }],
        listeners: {
        }
    });
    VersionX.panel.ResourcesDetail.Main.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.panel.ResourcesDetail.Main,MODx.FormPanel,{
    compareVersion: function (tf) {
        var cmid = tf.getValue();
        var backTo = (MODx.request.backTo) ? '&backTo='+MODx.request.backTo : '';
        MODx.loadPage('?namespace=versionx&a=resource&vid='+MODx.request['vid']+'&cmid='+cmid+backTo)
    },

    revertVersion: function(version) {
        if (version < 1) { console.log('Version not properly defined: '+version); }
        MODx.msg.confirm({
            title: _('versionx.resources.revert.confirm'),
            text: _('versionx.resources.revert.confirm.text',{id: version}),
            url: VersionX.config.connector_url,
            params: {
                version_id: version,
                content_id: VersionX.record.content_id,
                action: 'mgr/resources/revert'
            },
            listeners: {
                success: {fn: function() {
                    MODx.msg.status({
                        message: _('versionx.resources.reverted'),
                        delay: 4
                    });
                }, scope: this }
            }
        });
    }
});
Ext.reg('versionx-panel-resourcesdetail',VersionX.panel.ResourcesDetail.Main);
