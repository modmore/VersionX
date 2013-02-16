<script type="text/javascript">
    MODx.on("ready",function() {
        MODx.addTab("modx-resource-tabs",{
            title: _('versionx.tabheader'),
            id: 'versionx-resource-tab',
            width: '95%',
            items: [{
                xtype: 'versionx-panel-resources',
                //layout: 'anchor',
                width: 500
            },{
                html: '<hr />',
                width: '95%'
            },{
                layout: 'anchor',
                anchor: '1',
                items: [{
                    xtype: 'versionx-grid-resources'
                }]
            }]
        });

        /**
         * Handle auto-saving data.
         */
        if (VersionX.config.auto_save && VersionX.config.auto_save_resources) {
            window.saveDataToVersionX = function saveDataToVersionX() {
                var panel = Ext.getCmp('modx-panel-resource'),
                    form = panel.getForm(),
                    saveBtn = Ext.getCmp('modx-abtn-save'),
                    values;

                /** On the "save" event, set the saveBtn text back to Save */
                panel.on('save', function() {
                    saveBtn.setText(_('save'));
                });

                /**
                 * First trigger the beforeSubmit. This will prepare the form
                 * for submission, for example by setting RTE values to the hidden
                 * field. After that we get the values.
                 */
                panel.fireEvent('beforeSubmit', panel);
                values = form.getValues();

                /**
                 * We send the data to VersionX through Ajax.
                 */

                values.action = 'mgr/autosave';
                values.vx_type = 'vxResource';

                MODx.Ajax.request({
                    url: VersionX.config.connector_url,
                    baseParams: {
                        action: 'mgr/autosave',
                        type: 'vxResource'
                    },
                    params: values,
                    listeners: {
                        success: {
                            fn: function(foo, bar) {

                                console.log(foo, bar);
                            },
                            scope: panel
                        },
                        failure: {
                            fn: function(r) {
                                var now = new Date(),
                                    hours = now.getHours(),
                                    mins = now.getMinutes(),
                                    secs = now.getSeconds(),
                                    minutes = (mins < 10) ? '0' + mins : mins,
                                    seconds = (secs < 10) ? '0' + secs : secs,
                                    displayTime = hours + ':' + minutes + ':' + seconds;

                                saveBtn.setText( _('save') + ' (' + _('versionx.auto_saved', {when: displayTime}) + ')');

                                MODx.msg.status({
                                    title: _('versionx.auto_saved', {when: displayTime}),
                                    message: _('versionx.auto_saved.success'),
                                    delay: 10
                                });
                                MODx.msg.alert(_('error'), _('versionx.auto_save.error') + '<br /><br />' + r.message);
                                return false;
                            }
                        }
                    }


                });

            }
        }
    });
</script>
