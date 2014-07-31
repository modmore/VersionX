<?php
header("Content-Type: text/javascript");
require_once dirname(dirname(dirname(dirname(dirname(dirname(__FILE__)))))).'/config.core.php';
if (!defined('MODX_CORE_PATH'))  { define('MODX_CORE_PATH', '/core/'); }
	if (!defined('MODX_CONFIG_KEY')) { define('MODX_CONFIG_KEY', 'config'); }
	require_once( MODX_CORE_PATH . 'model/modx/modx.class.php');
	$modx = new modx();
	$modx->initialize('mgr');

echo "Ext.onReady(function() {
    Ext.QuickTips.init();
    MODx.load({ xtype: 'versionx-page-index'});
});

VersionX.page.Index = function(config) {
    config = config || {};
    config.id = config.id || 'versionx-panel-index';
    Ext.applyIf(config,{
        renderTo: 'versionx',
        cls: 'container',
        components: [{
            xtype: 'panel',
            html: '<h2>'+_('versionx')+'</h2>',
            border: false,
            cls: 'modx-page-header'
        },{
            xtype: 'panel',
            cls: 'x-panel-body',
            border: false,
            items: [{
                html: '<p>'+_('versionx.home.text')+'</p>',
                border: false,
                bodyCssClass: 'panel-desc'
            },{
                cls: 'main-wrapper',
                border: false,
                items: [{
                    xtype: 'modx-tabs',
                    cls: 'structure-tabs',
                    width: '98%',
                    border: true,
                    defaults: {
                        border: false,
                        autoHeight: true,
                        cls: 'main-wrapper',
                        defaults: {
                            border: false
                        }
                    },
                    items: [
";

$resources = "
					{
                        title: _('resources'),
                        items: [{
                            xtype: 'versionx-panel-resources'
                        },{
                            html: '<hr />'
                        },{
                            xtype: 'versionx-grid-resources'
                        }]
                    },";
if( $modx->hasPermission('save_document') ) { echo $resources; }
                        
$templates = "
					{
                        title: _('templates'),
                        items: [{
                            xtype: 'versionx-panel-templates'
                        },{
                            html: '<hr />'
                        },{
                            xtype: 'versionx-grid-templates'
                        }]
                    },";
if( $modx->haspermission('save_template') ) { echo $templates; }

$tmplvars = "
                     
                    {
                        title: _('tmplvars'),
                        items: [{
                            xtype: 'versionx-panel-templatevars'
                        },{
                            html: '<hr />'
                        },{
                            xtype: 'versionx-grid-templatevars'
                        }]
                    },";
if( $modx->haspermission('save_tv') ) { echo $tmplvars; }

$chunks = "
                    {
                        title: _('chunks'),
                        items: [{
                            xtype: 'versionx-panel-chunks'
                        },{
                            html: '<hr />'
                        },{
                            xtype: 'versionx-grid-chunks'
                        }]
                    },";
if( $modx->haspermission('save_chunk') ) { echo $chunks; }

$snippets = "
                    {
                        title: _('snippets'),
                        items: [{
                            xtype: 'versionx-panel-snippets'
                        },{
                            html: '<hr />'
                        },{
                            xtype: 'versionx-grid-snippets'
                        }]
                    },";
if( $modx->haspermission('save_snippet') ) { echo $snippet; }

$plugins = "
                    {
                        title: _('plugins'),
                        items: [{
                            xtype: 'versionx-panel-plugins'
                        },{
                            html: '<hr />'
                        },{
                            xtype: 'versionx-grid-plugins'
                        }]
                    }";
                    
echo "
                    ],
                    stateful: true,
                    stateId: config.id,
                    stateEvents: ['tabchange'],
                    getState: function() {
                        return { activeTab:this.items.indexOf(this.getActiveTab()) };
                    }
                }]
            }]
        }]
    });
    VersionX.page.Index.superclass.constructor.call(this,config);
};
Ext.extend(VersionX.page.Index,MODx.Component);
Ext.reg('versionx-page-index',VersionX.page.Index);";
?>
