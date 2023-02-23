<script type="text/javascript">
    (function() {
        var added = false;
        MODx.on("ready", function() {
            if (added) {
                return;
            }
            added = true;
            MODx.addTab("{$tabs_component_id}", {
                title: _('versionx.tabheader'),
                id: 'versionx-resource-tab',
                layout: 'anchor',
                defaults: {
                    anchor: '1',
                },
                items: [{
                    layout: 'anchor',
                    items: [{
                        xtype: 'versionx-grid-versions',
                        principal_package: '{$principal_package}',
                        principal_class: '{$principal_class}',
                        principal: '{$principal}',
                    }]
                }]
            });
        });
    })();
</script>
