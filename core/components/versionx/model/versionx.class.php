<?php
/**
 * VersionX
 *
 * Copyright 2011 by Mark Hamstra <hello@markhamstra.com>
 *
 * This file is part of VersionX, a real estate property listings component
 * for MODX Revolution.
 *
 * VersionX is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * VersionX is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * VersionX; if not, write to the Free Software Foundation, Inc., 59 Temple Place,
 * Suite 330, Boston, MA 02111-1307 USA
 *
 * @package versionx
*/

class VersionX {
    public $modx;
    protected $chunks;
    protected $tvs = array();
    public $config = array();
    public $categoryCache = array();

    public $debug = false;
    public $action = null;
    
    /**
     * if true then a new vesion has already been created
     * @param boolean
     * 
     */
    protected $created_new_version = FALSE;

    /**
     * @param \modX $modx
     * @param array $config
     */
    function __construct(modX &$modx,array $config = array()) {
        $this->modx =& $modx;

        $basePath = $this->modx->getOption('versionx.core_path',$config,$this->modx->getOption('core_path').'components/versionx/');
        $assetsUrl = $this->modx->getOption('versionx.assets_url',$config,$this->modx->getOption('assets_url').'components/versionx/');
        $assetsPath = $this->modx->getOption('versionx.assets_path',$config,$this->modx->getOption('assets_path').'components/versionx/');
        $this->config = array_merge(array(
            'base_bath' => $basePath,
            'core_path' => $basePath,
            'model_path' => $basePath.'model/',
            'processors_path' => $basePath.'processors/',
            'elements_path' => $basePath.'elements/',
            'templates_path' => $basePath.'templates/',
            'assets_path' => $assetsPath,
            'js_url' => $assetsUrl.'js/',
            'css_url' => $assetsUrl.'css/',
            'assets_url' => $assetsUrl,
            'connector_url' => $assetsUrl.'connector.php',
            'publish_document' => $this->modx->hasPermission('publish_document'),
            
        ),$config);

        require_once dirname(dirname(__FILE__)) . '/docs/version.inc.php';
        if (defined('VERSIONX_FULLVERSION')) {
            $this->config['version'] = VERSIONX_FULLVERSION;
        }
        $modelpath = $this->config['model_path'];
        $this->modx->addPackage('versionx',$modelpath);
        $this->modx->lexicon->load('versionx:default');
        
        $this->debug = $this->modx->getOption('versionx.debug',null,false);
        $this->getAction();
    }

    /**
     * @param string $ctx Context name
     * @return bool
     */
    public function initialize($ctx = 'web') {
        switch ($ctx) {
            case 'mgr':
                $this->modx->regClientStartupHTMLBlock('
                <script type="text/javascript">
                    Ext.onReady(function() {
                        VersionX.config = '.$this->modx->toJSON($this->config).';
                        VersionX.action = '.$this->action.';
                    });
                </script>

                <style type="text/css">
                    .ext-gecko .x-form-text, .ext-ie8 .x-form-text {padding-top: 0;}
                    .vx-added .x-form-item-label { color: green; }
                    .vx-changed .x-form-item-label { color: #dd6600; }
                    .vx-removed .x-form-item-label { color: #ff0000; }
                </style>');

                $this->modx->regClientStartupScript($this->config['js_url'].'mgr/versionx.class.js');
                $this->modx->regClientStartupScript($this->config['js_url'].'mgr/common/json2.js');
            break;
        }
        return true;
    }

    /**
    * Gets a Chunk and caches it; also falls back to file-based templates
    * for easier debugging.
    *
    * @access public
    * @param string $name The name of the Chunk
    * @param array $properties The properties for the Chunk
    * @return string The processed content of the Chunk
    * @author Shaun "splittingred" McCormick
    */
    public function getChunk($name,$properties = array()) {
        $chunk = null;
        if (!isset($this->chunks[$name])) {
            $chunk = $this->_getTplChunk($name);
            if (empty($chunk)) {
                $chunk = $this->modx->getObject('modChunk',array('name' => $name),true);
                if ($chunk == false) return false;
            }
            $this->chunks[$name] = $chunk->getContent();
        } else {
            $o = $this->chunks[$name];
            $chunk = $this->modx->newObject('modChunk');
            $chunk->setContent($o);
        }
        $chunk->setCacheable(false);
        return $chunk->process($properties);
    }

    /**
    * Returns a modChunk object from a template file.
    *
    * @access private
    * @param string $name The name of the Chunk. Will parse to name.chunk.tpl
    * @param string $postFix The postfix to append to the name
    * @return modChunk/boolean Returns the modChunk object if found, otherwise false.
    * @author Shaun "splittingred" McCormick
    */
    private function _getTplChunk($name,$postFix = '.tpl') {
        $chunk = false;
        $f = $this->config['elements_path'].'chunks/'.strtolower($name).$postFix;
        if (file_exists($f)) {
            $o = file_get_contents($f);
            /* @var modChunk $chunk */
            $chunk = $this->modx->newObject('modChunk');
            $chunk->set('name',$name);
            $chunk->setContent($o);
        }
        return $chunk;
    }
    /**
     * Workflow:
     *  1. Create a draft - this stores the data in versionx but would get the 
     *      last "published" versionx and put these fields into existing resource
     *  2. Publish - this would proceed as normal/default and create a new versionx record
     *  3. Submit for approval - this would do the same as Create a draft 
     *      but also send out an email to admins/editors
     *  4. Approve draft would do the same as Publish and send out an email to submitter
     *  5. Reject draft this would set the last published version to Published and create new record in versionx
     *  Note does not save the new record but retains it in class and then saveResourceWorkflow 
     *      will save object OnDocFormSave - this is to make sure all perms and system passed so not to save bad data! 
     * mode - upd, draft, submit, approved, rejected,
     * 
     * @param int|modResource|modStaticResource $resource
     * @param string $mode
     * @return bool  
     *
     */
    public function resourceWorkflow($resource, $mode = 'draft') {
        if ($resource instanceof modResource) {
            $this->resource = &$resource;
        } else {
            // $resource = $this->modx->getObject('modResource',(int)$resource);
            return false;
        }
        // $this->modx->log(xPDO::LOG_LEVEL_ERROR, '[VersionX:vxResource/'.$mode.'] Mode: ' .$mode.' -- '.$_POST['version_publish']);
        
        switch ($mode) {
            case 'approve':
                // send email to submitter
                $this->sendNote($resource->get('version_sendto'), 'Page Approved', 'Page has been approved  -  '.$resource->get('version_notes'));
            case 'publish':
                // set to published and act as normal versionx
                $this->resource->set('published', 1 );
                if ( $this->newResourceVersion($this->resource, $mode, FALSE)) {
                    
                } else {
                    return FALSE;
                }
                break;
            case 'unpublish':
                // set publish to 0 and act as normal versionx
                $this->resource->set('published', 0 );
                if ( $this->newResourceVersion($this->resource, $mode, FALSE)) {
                    
                } else {
                    return FALSE;
                }
                break;
            
            // below should set resource to the most current published version if it exists:
            // this is so any changes are not actually made to the resource but only the draft
            case 'reject':
                // @TODO
                // send email to submitter and revert
            case 'submitted':
                // send email to approver 
                $this->sendNote($resource->get('version_sendto'), 'Page Submitted', 'Page has been submitted  -  '.$resource->get('version_notes'));
            case 'draft':
            default:
                // make new version
                if ($this->newResourceVersion($this->resource, $mode, FALSE)) {
                    //$this->modx->log(xPDO::LOG_LEVEL_ERROR, '[VersionX:vxResource/'.$mode.'] created version');
                    $this->created_new_version = TRUE;
                    $currentVersion = $this->getCurrentWorkflowVersion($resource->get('id'), 'published');
                    if ( $currentVersion ) {
                        $this->resource = $currentVersion->retrieveData($this->resource, 'draft');
                        //$this->modx->log(xPDO::LOG_LEVEL_ERROR, '[VersionX:vxResource] retreive last published version?');
                    }
                } else {
                    return FALSE;
                }
                break;
        }
        
        return true;
    }
    /**
     * get current workflow version
     * @param (int) resource_id
     * @param (String) $type - last is for the last record excluding reject or publish which is the last un/published version
     * @return (Object) $currentVersion
     */
    public function getCurrentWorkflowVersion($resource_id, $type='last') {
        $c = $this->modx->newQuery('vxResource');
        //
        $c->where(array('content_id' => $resource_id));
        if ( $type == 'last' ) {
            $c->where(array('mode:!=' => 'reject'));
        } else {
            $c->where(array('mode:IN' => array('upd','publish','approve','unpublish')));
        }
        
        $c->sortby('version_id','DESC');
        $c->limit(1);
        
        $currentVersion = $this->modx->getObject('vxResource', $c);
        return $currentVersion;
    }
    /**
     * set current resource to current workflow draft for editing:
     * @param (Object) $resource
     * @return (boolean)
     */
    public function setCurrentWorkflowData($resource) {
        if ($resource instanceof modResource) {
            $this->resource = &$resource;
        } else {
            // $resource = $this->modx->getObject('modResource',(int)$resource);
            return false;
        }
        
        $currentVersion = $this->getCurrentWorkflowVersion($this->resource->get('id'));
        if ( $currentVersion ) {
            $this->resource = $currentVersion->retrieveData($this->resource, 'draft');
        }
        return TRUE;
    }
    
    /**
     * Creates a new version of a Resource.
     *
     * @param int|modResource|modStaticResource $resource
     * @param string $mode
     * @param (bool) $cleanup
     * @return bool
     *
     */
    public function newResourceVersion($resource, $mode = 'upd', $cleanup=TRUE) {
        if ( $this->created_new_version ) {
            return TRUE;
        }
        if ( $cleanup ) {
            if ($resource instanceof modResource) {
                // We're retrieving the resource again to clean up raw post data we don't want.
                $resource = $this->modx->getObject('modResource',$resource->get('id'));
            } else {
                $resource = $this->modx->getObject('modResource',(int)$resource);
            }
        }

        $rArray = $resource->toArray();

        /* @var vxResource $version */
        $version = $this->modx->newObject('vxResource');

        $v = array(
            'content_id' => $rArray['id'],
            'user' => $this->modx->user->get('id'),
            'mode' => $mode,
            'title' => $rArray[$this->modx->getOption('resource_tree_node_name',null,'pagetitle')],
            'context_key' => $rArray['context_key'],
            'class' => $rArray['class_key'],
            'content' => $resource->get('content'),
            'version_notes' => $resource->get('version_notes'),
            'version_number' => 1.01,
            'version_sendto' => $resource->get('version_sendto')
        );

        $version->fromArray($v);

        unset ($rArray['id'],$rArray['content']);
        $version->set('fields',$rArray);

        if (method_exists($resource,'getTemplateVars')) {
            $tvs = $resource->getTemplateVars();
        } else {
            $tvs = call_user_func(array($this,'getTemplateVars'),$resource);
        }
        $tvArray = array();
        /* @var modTemplateVar $tv */
        foreach ($tvs as $tv) {
            $tvArray[] = $tv->get(array('id','value'));
        }
        $version->set('tvs',$tvArray);

        if ($this->checkLastVersion('vxResource', $version, $this->debug)) {
            return $version->save();
        }
        return true;
    }


    /**
     * Creates a new version of a Template.
     *
     * @param \modTemplate $template
     * @param string $mode
     * @return bool
     *
     */
    public function newTemplateVersion(modTemplate $template, $mode = 'upd') {
        if (!($template instanceof modTemplate)) { return false; }

        $tArray = $template->toArray();

        /* @var vxTemplate $version */
        $version = $this->modx->newObject('vxTemplate');

        $v = array(
            'content_id' => $tArray['id'],
            'user' => $this->modx->user->get('id'),
            'mode' => $mode,
        );

        $version->fromArray(array_merge($v,$tArray));

        if($this->checkLastVersion('vxTemplate', $version)) {
            return $version->save();
        }
        return true;
    }


    /**
     * Creates a new version of a Template Variable.
     *
     * @param \modTemplateVar $tv
     * @param string $mode
     * @return bool
     *
     */
    public function newTemplateVarVersion(modTemplateVar $tv, $mode = 'upd') {
        if (!($tv instanceof modTemplateVar)) { return false; }

        $tArray = $tv->toArray();

        /* @var modTemplateVar $version */
        $version = $this->modx->newObject('vxTemplateVar');

        $v = array(
            'content_id' => $tArray['id'],
            'user' => $this->modx->user->get('id'),
            'mode' => $mode,
        );

        $version->fromArray(array_merge($v,$tArray));

        if($this->checkLastVersion('vxTemplateVar', $version)) {
            return $version->save();
        }
        return true;
    }
    /**
     * Create a new version of a Chunk.
     *
     * @param \modChunk $chunk
     * @param string $mode
     * @return bool
     */
    public function newChunkVersion(modChunk $chunk, $mode = 'upd') {
        if (!($chunk instanceof modChunk)) { return false; }

        $cArray = $chunk->toArray();

        /* @var vxChunk $version */
        $version = $this->modx->newObject('vxChunk');
        
        $v = array(
            'content_id' => $cArray['id'],
            'user' => $this->modx->user->get('id'),
            'mode' => $mode,
        );

        $version->fromArray(array_merge($v,$cArray));

        if($this->checkLastVersion('vxChunk', $version)) {
            return $version->save();
        }
        return true;
    }

    /**
     * Creates a new version of a Snippet.
     *
     * @param \modSnippet $snippet
     * @param string $mode
     * @return bool
     */
    public function newSnippetVersion(modSnippet $snippet, $mode = 'upd') {
        if (!($snippet instanceof modSnippet)) { return false; }

        $sArray = $snippet->toArray();

        /* @var vxSnippet $version */
        $version = $this->modx->newObject('vxSnippet');

        $v = array(
            'content_id' => $sArray['id'],
            'user' => $this->modx->user->get('id'),
            'mode' => $mode,
        );

        $version->fromArray(array_merge($v,$sArray));

        if($this->checkLastVersion('vxSnippet', $version)) {
            return $version->save();
        }
        return true;
    }

    /**
     * Creates a new version of a Plugin.
     *
     * @param \modPlugin $plugin
     * @param string $mode
     * @return bool
     */
    public function newPluginVersion(modPlugin $plugin, $mode = 'upd') {
        if (!($plugin instanceof modPlugin)) { return false; }

        $pArray = $plugin->toArray();

        /* @var vxPlugin $version */
        $version = $this->modx->newObject('vxPlugin');

        $v = array(
            'content_id' => $pArray['id'],
            'user' => $this->modx->user->get('id'),
            'mode' => $mode,
        );

        $version->fromArray(array_merge($v,$pArray));

        if($this->checkLastVersion('vxPlugin', $version)) {
            return $version->save();
        }
        return true;
    }

    /**
     * Gets & prepares version details for output.
     *
     * @param string $class
     * @param int $id
     * @param bool $json
     * @param string $prefix
     * @return bool|array
     */
    public function getVersionDetails($class = 'vxResource',$id = 0, $json = false, $prefix = '') {
        $v = $this->modx->getObject($class,$id);
        /* @var xPDOObject $v */
        if ($v instanceof $class) {
            $vArray = $v->toArray();
            $vArray['mode'] = $this->modx->lexicon('versionx.mode.'.$vArray['mode']);

            /* Class specific processing */
            switch ($class) {
                case 'vxResource':
                    $vArray = array_merge($vArray,$vArray['fields']);

                    if ($vArray['parent'] != 0) {
                        /* @var modResource $parent */
                        $parent = $this->modx->getObject('modResource',$vArray['parent']);
                        if ($parent instanceof modResource) $vArray['parent'] = $parent->get('pagetitle') .' ('.$vArray['parent'].')';
                    }

                    /* Process content type */
                    /* @var modContentType $ct */
                    $ct = $this->modx->getObject('modContentType',$vArray['content_type']);
                    if ($ct instanceof modContentType)
                        $vArray['content_type'] = $ct->get('name');

                    //$vArray['content'] = nl2br(htmlentities($vArray['content']));
                    $vArray['content'] = $vArray['content'];
                    // $this->modx->log(xPDO::LOG_LEVEL_ERROR,"[VersionX] Set Content for ID: ".$id.' -- '.$vArray['content'] );

                    if ($vArray['content_dispo'] == 1) $vArray['content_dispo'] = $this->modx->lexicon('attachment');
                    else $vArray['content_dispo'] = $this->modx->lexicon('inline');

                    /* Process boolean values */
                    $vArray['published'] = (intval($vArray['published'])) ? $this->modx->lexicon('yes') : $this->modx->lexicon('no');
                    $vArray['hidemenu'] = (intval($vArray['hidemenu'])) ? $this->modx->lexicon('yes') : $this->modx->lexicon('no');
                    $vArray['isfolder'] = (intval($vArray['isfolder'])) ? $this->modx->lexicon('yes') : $this->modx->lexicon('no');
                    $vArray['richtext'] = (intval($vArray['richtext'])) ? $this->modx->lexicon('yes') : $this->modx->lexicon('no');
                    $vArray['searchable'] = (intval($vArray['searchable'])) ? $this->modx->lexicon('yes') : $this->modx->lexicon('no');
                    $vArray['cacheable'] = (intval($vArray['cacheable'])) ? $this->modx->lexicon('yes') : $this->modx->lexicon('no');
                    $vArray['deleted'] = (intval($vArray['deleted'])) ? $this->modx->lexicon('yes') : $this->modx->lexicon('no');

                    /* Process time stamps */
                    $df = $this->modx->config['manager_date_format'].' '.$this->modx->config['manager_time_format'];
                    $vArray['saved'] = ($vArray['saved'] != 0) ? date($df,strtotime($vArray['saved'])) : '';
                    $vArray['publishedon'] = ($vArray['publishedon'] != 0) ? date($df,strtotime($vArray['publishedon'])) : '';
                    $vArray['pub_date'] = ($vArray['pub_date'] != 0) ? date($df,strtotime($vArray['pub_date'])) : '';
                    $vArray['unpub_date'] = ($vArray['unpub_date'] != 0) ? date($df,strtotime($vArray['unpub_date'])) : '';

                    /* Get TV captions */
                    $tvArray = array();
                    foreach ($vArray['tvs'] as $tv) {
                        if (!isset($this->tvs[$tv['id']]) || empty($this->tvs[$tv['id']])) {
                            /* @var modTemplateVar $tvObj */
                            $tvObj = $this->modx->getObject('modTemplateVar',$tv['id']);
                            if ($tvObj instanceof modTemplateVar) {
                                $caption = $tvObj->get('caption');
                                if (empty($caption)) $caption = $tvObj->get('name');
                                $this->tvs[$tv['id']] = $caption;
                            } else {
                                $this->tvs[$tv['id']] = 'tv'.$tv['id'];
                            }
                        }
                        $tvArray[] = array_merge($tv,array('caption' => $this->tvs[$tv['id']]));
                    }
                    $vArray['tvs'] = $tvArray;
                    break;
                case 'vxTemplateVar':
                    $vArray['category'] = $this->getCategory($vArray['category']);
                    if (is_array($vArray['input_properties'])) {
                        foreach ($vArray['input_properties'] as $key => $value) {
                            if ($decoded = $this->modx->fromJSON($value)) {
                                $vArray['input_properties'][$key] = $decoded;
                            }
                        }
                    }
                    if (is_array($vArray['output_properties'])) {
                        foreach ($vArray['output_properties'] as $key => $value) {
                            if ($decoded = $this->modx->fromJSON($value)) {
                                $vArray['output_properties'][$key] = $decoded;
                            }
                        }
                    }
                    break;

                case 'vxTemplate':
                    $vArray['content'] =  nl2br(str_replace(' ', '&nbsp;',htmlentities($vArray['content'])));
                    $vArray['category'] = $this->getCategory($vArray['category']);
                    break;

                case 'vxChunk':
                    $vArray['snippet'] =  nl2br(str_replace(' ', '&nbsp;',htmlentities($vArray['snippet'])));
                    $vArray['category'] = $this->getCategory($vArray['category']);
                    break;

                case 'vxSnippet':
                    $vArray['snippet'] =  nl2br(str_replace(' ', '&nbsp;',htmlentities($vArray['snippet'])));
                    $vArray['category'] = $this->getCategory($vArray['category']);
                    break;

                case 'vxPlugin':
                    $vArray['plugincode'] =  nl2br(str_replace(' ', '&nbsp;',htmlentities($vArray['plugincode'])));
                    $vArray['category'] = $this->getCategory($vArray['category']);
                    break;
            }

            /* @var modUserProfile $up */
            $up = $this->modx->getObject('modUserProfile',array('internalKey' => $vArray['user']));
            if ($up instanceof modUserProfile) $vArray['user'] = $up->get('fullname');

            if (!empty($prefix)) {
                $ta = array();
                foreach ($vArray as $tk => $tv) {
                    $ta[$prefix.$tk] = $tv;
                }
                $vArray = $ta;
            }
            if ($json) return $this->modx->toJSON($vArray);
            return $vArray;
        }
        return false;
    }

    /**
     * Provides backwards compatibility for MODX 2.0.8 (min. supported version)
     * Only use if modResource::getTemplateVars is not available. 
     * This function is identical to modResource::getTemplateVars in the MODX model. 
     * 
     * @static
     * @param modResource $resource
     * @return array|null
     */
    private static function getTemplateVars(modResource &$resource) {
        /* @var xPDOQuery $c */
        $c = $resource->xpdo->newQuery('modTemplateVar');
        $c->query['distinct'] = 'DISTINCT';
        $c->select($resource->xpdo->getSelectColumns('modTemplateVar', 'modTemplateVar'));
        if ($resource->isNew()) {
            $c->select(array(
                'modTemplateVar.default_text AS value',
                '0 AS resourceId'
            ));
        } else {
            $c->select(array(
                'IF(ISNULL(tvc.value),modTemplateVar.default_text,tvc.value) AS value',
                $resource->get('id').' AS resourceId'
            ));
        }
        $c->innerJoin('modTemplateVarTemplate','tvtpl',array(
            'tvtpl.tmplvarid = modTemplateVar.id',
            'tvtpl.templateid' => $resource->get('template'),
        ));
        if (!$resource->isNew()) {
            $c->leftJoin('modTemplateVarResource','tvc',array(
                'tvc.tmplvarid = modTemplateVar.id',
                'tvc.contentid' => $resource->get('id'),
            ));
        }
        $c->sortby('tvtpl.rank,modTemplateVar.rank');
        return $resource->xpdo->getCollection('modTemplateVar', $c);
    }

    /**
     * Checks the last saved version (if any).
     * Returns true if there is no earlier version, or something is different.
     * So if this returns true: go ahead and save the version.
     * If this returns false: nothing changed, don't bother.
     *
     * @param string $class
     * @param \xPDOObject $version
     *
     * @return bool
     */
    protected function checkLastVersion($class = 'vxResource', xPDOObject $version) {
        /* Get last version to make sure we've got some changes to save */
        $c = $this->modx->newQuery($class);
        $c->where(array('content_id' => $version->get('content_id')));
        $c->sortby('version_id','DESC');
        $c->limit(1);

        $lastVersion = $this->modx->getCollection($class,$c);
        /* @var vxResource $lastVersion */
        $lastVersion = !empty($lastVersion) ? array_shift($lastVersion) : array();
        
        /* If there's no earlier version, we can go ahead and
         return true to indicate we need to save the version */
        if (!($lastVersion instanceof $class)) { 
            if ($this->debug) $this->modx->log(xPDO::LOG_LEVEL_ERROR,"[VersionX] Saving a {$class} for ID {$version->get('content_id')}: No earlier version found.");
            return true;
        }

        $newVersionArray = $version->toArray();
        $lastVersionArray = $lastVersion->toArray();

        /* Get rid of excluded vars for the specific object. */
        $exclude = call_user_func(array($class,'getExcludeFields'));
        if ($this->debug) $this->modx->log(modX::LOG_LEVEL_ERROR,'[VersionX checkLastVersion] Exclude fields: ' . print_r($exclude, true));
        foreach ($exclude as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $subfield) {
                    if (isset($newVersionArray[$key]) && isset($newVersionArray[$key][$subfield])) {
                        unset ($newVersionArray[$key][$subfield]);
                    }
                    if (isset($lastVersionArray[$key]) && isset($lastVersionArray[$key][$subfield])) {
                        unset ($lastVersionArray[$key][$subfield]);
                    }
                }
            } else {
                if (isset($lastVersionArray[$value])) { unset($lastVersionArray[$value]); }
                if (isset($newVersionArray[$value])) { unset($newVersionArray[$value]); }
            }
        }

        $newVersionFlat = $this->flattenArray($newVersionArray);
        $lastVersionFlat = $this->flattenArray($lastVersionArray);

        if ($this->debug) {
            $this->modx->log(modX::LOG_LEVEL_ERROR,'[VersionX checkLastVersion] New: ' . print_r($newVersionArray, true));
            $this->modx->log(modX::LOG_LEVEL_ERROR,'[VersionX checkLastVersion] New Flattened: ' . $newVersionFlat);
            $this->modx->log(modX::LOG_LEVEL_ERROR,'[VersionX checkLastVersion] Last: ' . print_r($lastVersionArray, true));
            $this->modx->log(modX::LOG_LEVEL_ERROR,'[VersionX checkLastVersion] Last Flattened: ' . $newVersionFlat);
        }

        /* If the flattened arrays don't match there's a difference and we return true to indicate we need to save. */
        if ($newVersionFlat != $lastVersionFlat) {
            return true;
        }

        if ($this->debug) $this->modx->log(xPDO::LOG_LEVEL_ERROR,"[VersionX] Not saving a {$class} for ID {$version->get('content_id')}: No changes found.");
        /* If we got here, there was a last version but it seemed nothing changes.
        Return false to indicate to NOT save a new version. */
        return false;
    }

    /**
     * Flattens an array recursively.
     * @param array $array
     *
     * @return array|string
     */
    public function flattenArray(array $array = array()) {
        if (!is_array($array)) return (string)$array;

        $string = array();
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $value = '{' . $this->flattenArray($value) .'}';
            }
            if (!empty($value)) {
                $string[] = $key . ':' . $value;
            }
        }
        $string = implode(',',$string);
        return $string;
    }

    /**
     * Outputs the JavaScript needed to add a tab to the panels.
     *
     * @param string $class
     */
    public function outputVersionsTab ($class = 'vxResource') {
        if (!class_exists($class)) {
            $path = $this->config['model_path'].'versionx/'.strtolower($class).'.class.php';
            if (file_exists($path)) {
                require_once ($path);
            } 
            if (!class_exists($class)) {
                $this->modx->log(modX::LOG_LEVEL_ERROR,'[VersionX::outputVersionsTab] Error loading class '.$class);
                return;
            }
        }
        $langs = $this->_getLangs();
        $action = $this->getAction();
        $jsurl = $this->config['js_url'].'mgr/';
        
        /* Load class & set inVersion to true, indicating we're not looking at the VersionX controller. */
        $this->modx->regClientStartupScript($jsurl.'versionx.class.js');
        $this->modx->regClientStartupHTMLBlock('
            <script type="text/javascript">
                VersionX.config = '.$this->modx->toJSON($this->config).';
                VersionX.inVersion = true;
                VersionX.action = '.$action.';
                '.$langs.'
            </script>
        ');
        
        /* Get the different individual JS to add to the page */
        $tabjs = call_user_func(array($class,'getTabJavascript'));
        if (is_array($tabjs)) {
            foreach ($tabjs as $js) {
                $this->modx->regClientStartupScript($jsurl.$js);
            }
        }
        
        /* Get the template and register it */
        $tplName = call_user_func(array($class,'getTabTpl'));
        $tplFile = $this->config['templates_path'] . $tplName . '.tpl';
        if (file_exists($tplFile)) {
            $tpl = file_get_contents($tplFile);
            if (!empty($tpl)) {
                $this->modx->regClientStartupHTMLBlock($tpl);
            }
        }
        
        
    }
    /**
     * Outputs the JavaScript needed to add custom fields to existing panels.
     *
     * @param string $class
     */
    public function outputVersionsFields ($class = 'vxResource', $loadConfig=FALSE) {
        if (!class_exists($class)) {
            $path = $this->config['model_path'].'versionx/'.strtolower($class).'.class.php';
            if (file_exists($path)) {
                require_once ($path);
            } 
            if (!class_exists($class)) {
                $this->modx->log(modX::LOG_LEVEL_ERROR,'[VersionX::outputVersionsFields] Error loading class '.$class);
                return;
            }
        }
        
        /* Load class & set inVersion to true, indicating we're not looking at the VersionX controller. */
        if ( $loadConfig ){
            $langs = $this->_getLangs();
            $action = $this->getAction();
            $jsurl = $this->config['js_url'].'mgr/';
            
            $this->modx->regClientStartupScript($jsurl.'versionx.class.js');
            $this->modx->regClientStartupHTMLBlock('
                <script type="text/javascript">
                    VersionX.config = '.$this->modx->toJSON($this->config).';
                    VersionX.inVersion = true;
                    VersionX.action = '.$action.';
                    '.$langs.'
                </script>
            ');
        }
        
        /* Get the template and register it */
        $tplName = call_user_func(array($class,'getFieldsTpl'));
        $tplFile = $this->config['templates_path'] . $tplName . '.tpl';
        if (file_exists($tplFile)) {
            $tpl = file_get_contents($tplFile);
            if (!empty($tpl)) {
                $this->modx->regClientStartupHTMLBlock($tpl);
            }
        }
        
    }

    /**
     * Gets language strings for use on non-VersionX controllers.
     * @return string
     */
    public function _getLangs() {
        $entries = $this->modx->lexicon->loadCache('versionx');
		$langs = 'Ext.applyIf(MODx.lang,' . $this->modx->toJSON($entries) . ');';
        return $langs;
    }

    /**
     * Gets the action ID for the VersionX controller.
     * 
     * @return int
     */
    public function getAction() {
        $action = $this->action;
        if (!$action) {
            /* @var modAction $action */
            $action = $this->modx->getObject('modAction',array(
                'namespace' => 'versionx',
                'controller' => 'controllers/index',
            ));
            if ($action) {
                $action = $action->get('id');
                $this->action = $action;
            } 
        }
        return $action;
    }

    /**
     * @param $id
     *
     * @return string
     */
    public function getCategory($id) {
        if (!$id || $id == 0) return '';
        if (isset($this->categoryCache[$id])) {
            return $this->categoryCache[$id];
        }
        /* @var modCategory $category */
        $category = $this->modx->getObject('modCategory',(int)$id);
        if ($category) {
            return $this->categoryCache[$id] = $category->get('category') . " ($id)";
        } else {
            return (string)$id;
        }
    }
    /**
     * Send email note
     */
    public function sendNote($to, $subject, $message, $chunk='versionxNotice') {
        /* load mail service */
        $this->modx->getService('mail', 'mail.modPHPMailer');

        /* set HTML */
        $emailHtml = $message;
        $this->modx->mail->setHTML($emailHtml);
        $emailFrom = $to;
        $emailFromName = 'webmaster';
        /* set email main properties */
        $this->modx->mail->set(modMail::MAIL_BODY,$emailHtml );
        $this->modx->mail->set(modMail::MAIL_FROM, $emailFrom);// current user email
        $this->modx->mail->set(modMail::MAIL_FROM_NAME, $emailFromName);// current user
        //$this->modx->mail->set(modMail::MAIL_SENDER, $emailFrom);
        $this->modx->mail->set(modMail::MAIL_SUBJECT, $subject);
        
        /* add to: with support for multiple addresses */
        $emailList = explode(',',$to);
        foreach ($emailList as $email) {
            $this->modx->mail->address('to',$email);
        }
        
        $sent = $this->modx->mail->send();
        $this->modx->mail->reset(array(
            modMail::MAIL_CHARSET => $this->modx->getOption('mail_charset',null,'UTF-8'),
            modMail::MAIL_ENCODING => $this->modx->getOption('mail_encoding',null,'8bit'),
        ));

        if (!$sent) {
            $this->modx->log(modX::LOG_LEVEL_ERROR,'[VersionX] '.print_r($this->modx->mail->mailer->ErrorInfo,true));
        }
    }
}

