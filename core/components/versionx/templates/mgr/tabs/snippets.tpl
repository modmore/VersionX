<script type="text/javascript">
    MODx.on("ready",function() {
        MODx.addTab("modx-snippet-tabs",{
            title: _('versionx.tabheader'),
            id: 'versionx-snippets-tab',
            width: '95%',
            items: [{
                xtype: 'versionx-panel-snippets',
                layout: 'anchor',
                width: 500
            },{
                html: '<hr />',
                width: '95%'
            },{
                layout: 'anchor',
                anchor: '1',
                items: [{
                    xtype: 'versionx-grid-snippets'
                }]
            }]
        });
    });
</script>
