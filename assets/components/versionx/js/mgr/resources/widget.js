
VersionX.grid.ResourcesWidget = function(config) {
    config = config || {};
    Ext.applyIf(config,{
		url: VersionX.config.connector_url,
		id: 'versionx-grid-resources',
		baseParams: {
            action: 'mgr/resources/getlist',
            resource: (VersionX.inVersion) ? MODx.request['id'] : 0,
            uniqueOnly: 1
        },
        params: [],
        viewConfig: {
            forceFit: true,
            enableRowBody: true,
            emptyText: _('versionx.error.noresults')
        },
		fields: [
            {name: 'version_id', type: 'int'},
            {name: 'content_id', type: 'int'},
            {name: 'saved', type: 'string'},
            {name: 'username', type: 'string'},
            {name: 'mode', type: 'string'},
            {name: 'marked', type: 'boolean'},
            {name: 'title', type: 'string'},
            {name: 'context_key', type: 'string'},
            {name: 'class', type: 'string'}
        ],
        paging: true,
        pageSize: 5,
		remoteSort: true,
		columns: [{
			header: _('id'),
			dataIndex: 'content_id',
		    sortable: true,
			width: .1
		},{
			header: _('versionx.saved'),
			dataIndex: 'saved',
			sortable: true,
			width: .3
		},{
			header: _('versionx.title'),
			dataIndex: 'title',
		    sortable: true,
			width: .3
		},{
			header: _('user'),
			dataIndex: 'username',
		    sortable: true,
			width: .15
		},{
			header: _('versionx.mode'),
			dataIndex: 'mode',
		    sortable: true,
			width: .15,
            renderer: function (val) { return _('versionx.mode.'+val); }
		},{
			header: _('versionx.marked'),
			dataIndex: 'marked',
		    sortable: true,
			width: .1,
            hidden: true
		},{
			header: _('context'),
			dataIndex: 'context_key',
		    sortable: true,
			width: .1,
            hidden: true
		},{
			header: _('class_key'),
			dataIndex: 'class',
		    sortable: true,
			width: .2,
            hidden: true
		}]
		,listeners: {}
    });
    VersionX.grid.ResourcesWidget.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.grid.ResourcesWidget,MODx.grid.Grid,{
    getMenu: function() {
        var r = this.getSelectionModel().getSelected();
        var d = r.data;

        var m = [];
        m.push({
            text: _('versionx.menu.viewdetails'),
            handler: function() {
                var eid = d.version_id;
                MODx.loadPage('?namespace=versionx&a=resource&vid='+eid)
            }
        },{
            text: _('versionx.widget.resources.update'),
            handler: function() {
                var eid = d.content_id;
                /* Be sure to be compatible for MODX 2.3 */
                var action = (MODx.action && MODx.action['resource/update']) ? MODx.action['resource/update'] : 'resource/update';
                MODx.loadPage('?a=' + action + '&id=' + eid);
            }
        });
        return m;
    }
});
Ext.reg('versionx-grid-resources-widget',VersionX.grid.ResourcesWidget);
