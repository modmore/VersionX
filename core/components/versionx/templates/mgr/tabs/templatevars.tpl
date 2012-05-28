<script type="text/javascript">
    MODx.on("ready",function() {
        MODx.addTab("modx-tv-tabs",{
            title: _('versionx.tabheader'),
            id: 'versionx-templatevar-tab',
            width: '95%',
            items: [{
                xtype: 'versionx-panel-templatevars',
                layout: 'anchor',
                width: 500
            },{
                html: '<hr />',
                width: '95%'
            },{
                layout: 'anchor',
                anchor: '1',
                items: [{
                    xtype: 'versionx-grid-templatevars'
                }]
            }]
        });
    });
</script>
