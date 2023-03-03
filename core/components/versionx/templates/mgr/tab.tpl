<script type="text/javascript">
    (function() {
        var added = false;

        // Use whichever ready event is first
        MODx.on('ready', function() {
            addVersionXTab();
        });
        Ext.onReady(function() {
            addVersionXTab();
        });

        function addVersionXTab() {
            if (added) {
                return;
            }
            added = true;
            MODx.addTab('{$tabs_component_id}', {
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
            // Refresh versions grid after save
            var panel = Ext.getCmp('{$panel_id}');
            panel.on('success', function(o) {
                panel.find('itemId', 'versionx-grid-deltas')[0].refresh();
            });
        }
    })();
</script>
