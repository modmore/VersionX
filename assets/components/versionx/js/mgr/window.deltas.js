VersionX.window.Deltas = function(config) {
    config = config || {};
    var win = this;
    Ext.applyIf(config, {
        title: 'View Details',
        url: VersionX.config.connectorUrl,
        baseParams: {
            action: 'mgr/'
        },
        cls: 'versionx-window',
        autoHeight: false,
        constrain: true,
        layout: 'form',
        buttons: [{
            text: config.cancelBtnText || _('cancel')
            ,scope: this
            ,handler: function() { config.closeAction !== 'close' ? this.hide() : this.close(); }
        }],
        fields: [{
            xtype: 'modx-panel',
            layout: 'anchor',
            items: [{
                xtype: 'versionx-grid-deltas',
                principal_package: config.record.principal_package,
                principal_class: config.record.principal_class,
                principal: config.record.principal,
                type: config.record.type,
            }]
        }],
    });
    VersionX.window.Deltas.superclass.constructor.call(this, config);
    // Set a large size that's still smaller than the viewport.
    this.on('afterrender', function(win) {
        var maxWidth = Ext.getBody().getViewSize().width - 200,
            width = 1200;

        if (width > maxWidth) {
            width = maxWidth;
        }

        var height = Ext.getBody().getViewSize().height - 30;
        win.setSize(width, height);
        win.center();
    });

    // Make sure when resizing the browser window, the Ext window stays in bounds
    Ext.EventManager.onWindowResize( function() {
        var height = Ext.getBody().getViewSize().height - 30;
        if (win.getHeight() > height) {
            win.setHeight(height);
            win.center();
        }
        var width = Ext.getBody().getViewSize().width - 200;
        if (win.getWidth() > width) {
            win.setWidth(width);
            win.center();
        }

    });
}
Ext.extend(VersionX.window.Deltas, MODx.Window);
Ext.reg('versionx-window-deltas', VersionX.window.Deltas);
