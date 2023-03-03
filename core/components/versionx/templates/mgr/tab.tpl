<script type="text/javascript">
    (function() {
        var added = false;
        Ext.onReady(function() {
            if (added) {
                return;
            }
            added = true;
            MODx.addTab("{$tabs_component_id}", {
                title: _('versionx.tabheader'),
                id: 'versionx-tab',
                layout: 'anchor',
                defaults: {
                    anchor: '1',
                },
                items: [{
                    layout: 'anchor',
                    items: [{
                        xtype: 'versionx-grid-deltas',
                        principal_package: '{$principal_package}',
                        principal_class: '{$principal_class}',
                        principal: '{$principal}',
                        type: '{$type}',
                    }]
                }]
            });
        });
    })();
</script>
