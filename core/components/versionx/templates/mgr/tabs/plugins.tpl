<script type="text/javascript">
    (function(){
        var added = false;
        MODx.on("ready",function() {
            if (added) {
                return;
            }
            added = true;
            MODx.addTab("modx-plugin-tabs",{
                title: _('versionx.tabheader'),
                id: 'versionx-snippets-tab',
                width: '95%',
                items: [{
                    xtype: 'versionx-panel-plugins',
                    layout: 'anchor',
                    width: 500
                },{
                    html: '<hr />',
                    width: '95%'
                },{
                    layout: 'anchor',
                    anchor: '1',
                    items: [{
                        xtype: 'versionx-grid-plugins'
                    }]
                }]
            });
        });
    })();
</script>
