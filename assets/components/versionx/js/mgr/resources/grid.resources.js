
VersionX.grid.Resources = function(config) {
    config = config || {};
    Ext.applyIf(config,{
		url: VersionX.config.connector_url,
		id: 'versionx-grid-resources',
		baseParams: {
            action: 'mgr/resources/getlist',
            resource: (VersionX.inVersion) ? MODx.request['id'] : 0
        },
        params: [],
        viewConfig: {
            forceFit: true,
            enableRowBody: true
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
		remoteSort: true,
		columns: [{
			header: _('versionx.version_id'),
			dataIndex: 'version_id',
			sortable: true,
			width: .1
		},{
			header: _('versionx.content_id',{what: _('resource')}),
			dataIndex: 'content_id',
		    sortable: true,
			width: .1
		},{
			header: _('versionx.saved'),
			dataIndex: 'saved',
			sortable: true,
			width: .2
		},{
			header: _('versionx.title'),
			dataIndex: 'title',
		    sortable: true,
			width: .4
		},{
			header: _('user'),
			dataIndex: 'username',
		    sortable: true,
			width: .2
		},{
			header: _('versionx.mode'),
			dataIndex: 'mode',
		    sortable: true,
			width: .1,
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
			width: .1
		},{
			header: _('class_key'),
			dataIndex: 'class',
		    sortable: true,
			width: .2
		}]
		,listeners: {}
    });
    VersionX.grid.Resources.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.grid.Resources,MODx.grid.Grid,{
    getMenu: function() {
        var r = this.getSelectionModel().getSelected();
        var d = r.data;

        var m = [];
        m.push({
            text: _('versionx.menu.viewdetails'),
            handler: function(grid, rowIndex, e) {
                var eid = d.version_id;
                var backTo = (VersionX.inVersion) ? '&backTo='+MODx.request['a']+'-'+MODx.request['id'] : '';
                window.location.href = '?a='+VersionX.action+'&action=resource&vid='+eid+backTo;
            }
        });
        if (m.length > 0) {
            this.addContextMenuItem(m);
        }
    }
});
Ext.reg('versionx-grid-resources',VersionX.grid.Resources);
