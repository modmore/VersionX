Ext.ns('VersionX.panel.Common');
VersionX.panel.Common.ContentPanel = function(config) {
    config = config || {};
    config.id = config.id || Ext.id();
    Ext.apply(config,{
        items: [{
            layout: 'column',
            border: false,
            items: [{
                columnWidth: 1,
                layout: 'form',
                border: false,
                defaults: {
                    width: '97%'
                },
                items: [{
                    xtype: 'panel',
                    border: false,
                    style: 'border-bottom: 1px solid black; font-weight: bold;',
                    html: _('versionx.resources.detail.tabs.resource-content.columnheader', {id:config.vxRecord.version_id}) +
                        (config.vxRecordCmp ? ' + ' + _('versionx.resources.detail.tabs.resource-content.columnheader', {id:config.vxRecordCmp.version_id}) : '')
                },{
                    xtype: 'panel',
                    border: false,
                    style: 'padding: 15px 10px 10px 10px;',
                    id: config.id + '-diff',
                    html: (config.vxRecord) ? ((config.vxRecord[config.vxContentField]) ? config.vxRecord[config.vxContentField] : '<em>Empty</em>') : '<em>No Version Chosen</em>'
                }]
            }]
        }]
    });

    /*
    if ( config.vxRecordCmp ) {
        config.items[0].items[0].columnWidth = .5;
        config.items[0].items.push({
            columnWidth: .5,
            layout: 'form',
            border: false,
            defaults: {
                width: '97%'
            },
            items: [{
                xtype: 'panel',
                border: false,
                style: 'border-bottom: 1px solid black; font-weight: bold;',
                html: _('versionx.resources.detail.tabs.resource-content.columnheader', {id:config.vxRecordCmp.version_id})
            },{
                xtype: 'panel',
                border: false,
                style: 'padding: 15px 10px 10px 10px;',
                html: (config.vxRecordCmp) ? ((config.vxRecordCmp[config.vxContentField]) ? config.vxRecordCmp[config.vxContentField] : '<em>Empty</em>') : '<em>No Version Chosen</em>'
            }]
        });
    }*/
    
    VersionX.panel.Common.ContentPanel.superclass.constructor.call(this,config);
    this.on('afterrender', this.viewDiff)
};
Ext.extend(VersionX.panel.Common.ContentPanel,MODx.Panel,{
    viewDiff: function() {
        if ( this.config.vxRecordCmp ) {
            var panel = this;
            setTimeout(function() {
                var current = panel.config.vxRecord[panel.config.vxContentField],
                    comparedTo = (panel.config.vxRecordCmp[panel.config.vxContentField]) ? panel.config.vxRecordCmp[panel.config.vxContentField] : '';

                var diff = JsDiff.diffLines(current, comparedTo),
                    display = document.getElementById(panel.config.id + '-diff'),
                    fragment = document.createDocumentFragment();

                diff.forEach(function(part){
                    // green for additions, red for deletions
                    // grey for common parts
                    var span = document.createElement('span');
                    span.className = part.added ? 'vx-added vx-inlinediff-added' : part.removed ? 'red vx-removed vx-inlinediff-removed' : '';
                    span.innerHTML = part.value;
                    fragment.appendChild(span);
                });

                display.innerHTML = '';
                display.appendChild(fragment);
            }, 100);
        }
    }
});
Ext.reg('versionx-panel-common-contentpanel',VersionX.panel.Common.ContentPanel);