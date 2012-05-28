<script type="text/javascript">
    MODx.on("ready",function() {
        MODx.addTab("modx-chunk-tabs",{
            title: _('versionx.tabheader'),
            id: 'versionx-chunks-tab',
            width: '95%',
            items: [{
                xtype: 'versionx-panel-chunks',
                layout: 'anchor',
                width: 500
            },{
                html: '<hr />',
                width: '95%'
            },{
                layout: 'anchor',
                anchor: '1',
                items: [{
                    xtype: 'versionx-grid-chunks'
                }]
            }]
        });
    });
</script>
