
VersionX.panel.ResourcesDetail = function(config) {
    config = config || {};
    Ext.apply(config,{
        id: 'versionx-panel-resourcesdetail',
        border: false,
        forceLayout: true,
        width: '98%',
        layout: 'form',
        items: [{
            html: '<p>'+_('versionx.resources.detail.text')+'</p>'
        },{
            layout: 'column',
            border: false,
            items: [{
                columnWidth: .5,
                layout: 'form',
                border: false,
                items: [{
                    xtype: 'statictextfield',
                    fieldLabel: _('resource')+' '+_('id'),
                    name: 'content_id'
                },{
                    xtype: 'statictextfield',
                    fieldLabel: _('versionx.title'),
                    name: 'title',
                    width: '97%'
                }]
            },{
                columnWidth: .5,
                layout: 'form',
                border: false,
                items: [{
                    width: '97%',
                    xtype: 'versionx-combo-resourceversions',
                    fieldLabel: _('versionx.compare_to'),
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
        },{
            xtype: 'versionx-panel-versionheader',
            title: 'Version Details'
        },{
            layout: 'column',
            border: false,
            items: [{
                columnWidth: .5,
                layout: 'form',
                border: false,
                items: [{
                    xtype: 'statictextfield',
                    fieldLabel: _('versionx.version_id'),
                    name: 'version_id'
                },{
                    xtype: 'statictextfield',
                    fieldLabel: _('user'),
                    name: 'user'
                },{
                    xtype: 'statictextfield',
                    fieldLabel: _('versionx.saved'),
                    name: 'saved'
                },{
                    xtype: 'statictextfield',
                    fieldLabel: _('versionx.mode'),
                    name: 'mode'
                }]
            },{
                columnWidth: .5,
                layout: 'form',
                border: false,
                items: [{
                    xtype: 'statictextfield',
                    fieldLabel: _('versionx.version_id'),
                    name: 'cm_version_id'
                },{
                    xtype: 'statictextfield',
                    fieldLabel: _('user'),
                    name: 'cm_user'
                },{
                    xtype: 'statictextfield',
                    fieldLabel: _('versionx.saved'),
                    name: 'cm_saved'
                },{
                    xtype: 'statictextfield',
                    fieldLabel: _('versionx.mode'),
                    name: 'cm_mode'
                }]
            }]
        },{
            xtype: 'versionx-panel-versionheader',
            title: 'Resource Fields'
        },{
            layout: 'column',
            border: false,
            items: [{
                columnWidth: .5,
                layout: 'form',
                border: false,
                defaults: {
                    width: '97%'
                },
                items: [{
                    xtype: 'statictextfield',
                    fieldLabel: _('resource_pagetitle'),
                    name: 'pagetitle'
                },{
                    xtype: 'statictextfield',
                    fieldLabel: _('resource_longtitle'),
                    name: 'longtitle'
                },{
                    xtype: 'statictextfield',
                    fieldLabel: _('resource_description'),
                    name: 'description'
                },{
                    xtype: 'statictextfield',
                    fieldLabel: _('resource_alias'),
                    name: 'alias'
                },{
                    xtype: 'statictextfield',
                    fieldLabel: _('resource_link_attributes'),
                    name: 'link_attributes'
                },{
                    xtype: 'textarea',
                    readOnly: true,
                    fieldLabel: _('resource_summary'),
                    name: 'introtext'
                },{
                    xtype: 'statictextfield',
                    fieldLabel: _('resource_parent'),
                    name: 'parent'
                },{
                    xtype: 'statictextfield',
                    fieldLabel: _('resource_menutitle'),
                    name: 'menutitle'
                },{
                    xtype: 'statictextfield',
                    fieldLabel: _('resource_menuindex'),
                    name: 'menuindex'
                },{
                    xtype: 'statictextfield',
                    fieldLabel: _('resource_published'),
                    name: 'published'
                },{
                    xtype: 'statictextfield',
                    fieldLabel: _('resource_hide_from_menus'),
                    name: 'hidemenu'
                }]
            },{
                columnWidth: .5,
                layout: 'form',
                border: false,
                defaults: {
                    width: '97%'
                },
                items: [{
                    xtype: 'statictextfield',
                    fieldLabel: _('resource_pagetitle'),
                    name: 'cm_pagetitle'
                },{
                    xtype: 'statictextfield',
                    fieldLabel: _('resource_longtitle'),
                    name: 'cm_longtitle'
                },{
                    xtype: 'statictextfield',
                    fieldLabel: _('resource_description'),
                    name: 'cm_description'
                },{
                    xtype: 'statictextfield',
                    fieldLabel: _('resource_alias'),
                    name: 'cm_alias'
                },{
                    xtype: 'statictextfield',
                    fieldLabel: _('resource_link_attributes'),
                    name: 'cm_link_attributes'
                },{
                    xtype: 'textarea',
                    readOnly: true,
                    fieldLabel: _('resource_summary'),
                    name: 'cm_introtext'
                },{
                    xtype: 'statictextfield',
                    fieldLabel: _('resource_parent'),
                    name: 'cm_parent'
                },{
                    xtype: 'statictextfield',
                    fieldLabel: _('resource_menutitle'),
                    name: 'cm_menutitle'
                },{
                    xtype: 'statictextfield',
                    fieldLabel: _('resource_menuindex'),
                    name: 'cm_menuindex'
                },{
                    xtype: 'statictextfield',
                    fieldLabel: _('resource_published'),
                    name: 'cm_published'
                },{
                    xtype: 'statictextfield',
                    fieldLabel: _('resource_hide_from_menus'),
                    name: 'cm_hidemenu'
                }]
            }]
        },{
            xtype: 'versionx-panel-versionheader',
            title: _('resource_content')
        },{
            layout: 'column',
            border: false,
            items: [{
                columnWidth: .5,
                layout: 'form',
                border: false,
                defaults: {
                    width: '97%'
                },
                items: [{
                    xtype: 'panel',
                    border: false,
                    html: (VersionX.record) ? ((VersionX.record.content) ? VersionX.record.content : '<em>Empty</em>') : '<em>No Version Chosen</em>'
                }]
            },{
                columnWidth: .5,
                layout: 'form',
                border: false,
                defaults: {
                    width: '97%'
                },
                items: [{
                    xtype: 'panel',
                    border: false,
                    html: (VersionX.cmrecord) ? ((VersionX.cmrecord.cm_content) ? VersionX.cmrecord.cm_content : '<em>Empty</em>') : '<em>No Version Chosen</em>'
                }]
            }]
        },{
            xtype: 'versionx-panel-versionheader',
            title: _('template_variables')
        },{
            layout: 'column',
            border: false,
            items: [{
                columnWidth: .5,
                border: false,
                layout: 'form',
                id: 'versionx-resource-tvs',
                defaults: {
                    width: '97%'
                },
                items: []
            },{
                columnWidth: .5,
                border: false,
                layout: 'form',
                id: 'versionx-resource-cm-tvs',
                defaults: {
                    width: '97%'
                },
                items: []
            }]
        },{
            xtype: 'versionx-panel-versionheader',
            title: _('page_settings')
        },{
            layout: 'column',
            border: false,
            items: [{
                columnWidth: .5,
                layout: 'form',
                border: false,
                items: [{
                    xtype: 'statictextfield',
                    fieldLabel: _('resource_folder'),
                    name: 'isfolder'
                },{
                    xtype: 'statictextfield',
                    fieldLabel: _('resource_richtext'),
                    name: 'richtext'
                },{
                    xtype: 'statictextfield',
                    fieldLabel: _('resource_publishedon'),
                    name: 'publishedon'
                },{
                    xtype: 'statictextfield',
                    fieldLabel: _('resource_publishdate'),
                    name: 'pub_date'
                },{
                    xtype: 'statictextfield',
                    fieldLabel: _('resource_unpublishdate'),
                    name: 'unpub_date'
                },{
                    xtype: 'statictextfield',
                    fieldLabel: _('resource_searchable'),
                    name: 'searchable'
                },{
                    xtype: 'statictextfield',
                    fieldLabel: _('resource_cacheable'),
                    name: 'cacheable'
                },{
                    xtype: 'statictextfield',
                    fieldLabel: _('deleted'),
                    name: 'deleted'
                },{
                    xtype: 'statictextfield',
                    fieldLabel: _('resource_content_type'),
                    name: 'content_type'
                },{
                    xtype: 'statictextfield',
                    fieldLabel: _('resource_contentdispo'),
                    name: 'content_dispo'
                },{
                    xtype: 'statictextfield',
                    fieldLabel: _('class_key'),
                    name: 'class_key'
                }]
            },{
                columnWidth: .5,
                layout: 'form',
                border: false,
                items: [{
                    xtype: 'statictextfield',
                    fieldLabel: _('resource_folder'),
                    name: 'cm_isfolder'
                },{
                    xtype: 'statictextfield',
                    fieldLabel: _('resource_richtext'),
                    name: 'cm_richtext'
                },{
                    xtype: 'statictextfield',
                    fieldLabel: _('resource_publishedon'),
                    name: 'cm_publishedon'
                },{
                    xtype: 'statictextfield',
                    fieldLabel: _('resource_publishdate'),
                    name: 'cm_pub_date'
                },{
                    xtype: 'statictextfield',
                    fieldLabel: _('resource_unpublishdate'),
                    name: 'cm_unpub_date'
                },{
                    xtype: 'statictextfield',
                    fieldLabel: _('resource_searchable'),
                    name: 'cm_searchable'
                },{
                    xtype: 'statictextfield',
                    fieldLabel: _('resource_cacheable'),
                    name: 'cm_cacheable'
                },{
                    xtype: 'statictextfield',
                    fieldLabel: _('deleted'),
                    name: 'cm_deleted'
                },{
                    xtype: 'statictextfield',
                    fieldLabel: _('resource_content_type'),
                    name: 'cm_content_type'
                },{
                    xtype: 'statictextfield',
                    fieldLabel: _('resource_contentdispo'),
                    name: 'cm_content_dispo'
                },{
                    xtype: 'statictextfield',
                    fieldLabel: _('class_key'),
                    name: 'cm_class_key'
                }]
            }]
        }],
        listeners: {
        }
    });
    VersionX.panel.ResourcesDetail.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.panel.ResourcesDetail,MODx.FormPanel,{
    compareVersion: function (tf, nv, ov) {
        cmid = tf.getValue();
        window.location.href = '?a='+MODx.request['a']+'&action=resource&vid='+MODx.request['vid']+'&cmid='+cmid;
    }
});
Ext.reg('versionx-panel-resourcesdetail',VersionX.panel.ResourcesDetail);

VersionX.panel.ResourcesDetailLeft = function(config) {
    config = config || {};
    Ext.apply(config,{
        id: 'versionx-panel-resourcesdetail',
        border: false,
        forceLayout: true,
        width: '98%',
        items: [{
            html: '<p>'+_('versionx.resources.detail.text')+'</p>'
        },{
        }]
    });
    VersionX.panel.ResourcesDetailLeft.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.panel.ResourcesDetailLeft,MODx.FormPanel);
Ext.reg('versionx-panel-resourcesdetailleft',VersionX.panel.ResourcesDetailLeft);
