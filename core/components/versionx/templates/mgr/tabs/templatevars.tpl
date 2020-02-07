<script type="text/javascript">
    (function(){
        var added = false;
        MODx.on("ready",function() {
            if (added) {
                return;
            }
            added = true;
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
    })();
</script>
