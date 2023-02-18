VersionX.window.Base = function(config) {
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
            html: '<h2>TESTING</h2>'
        }],
    });
    VersionX.window.Base.superclass.constructor.call(this, config);
    // Set a large size that's still smaller than the viewport.
    this.on('afterrender', function(win) {
        var width = Ext.getBody().getViewSize().width - 200;
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
Ext.extend(VersionX.window.Base, MODx.Window, {
    getDeltas: function() {

    },
});
Ext.reg('versionx-window-base', VersionX.window.Base);
