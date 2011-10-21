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
    private $chunks;
    private $tvs = array();
    public $config = array();


    /**
     * @param \modX $modx
     * @param array $config
     * @return \VersionX
     *
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
            'assets_path' => $assetsPath,
            'js_url' => $assetsUrl.'js/',
            'css_url' => $assetsUrl.'css/',
            'assets_url' => $assetsUrl,
            'connector_url' => $assetsUrl.'connector.php',
        ),$config);

        $modelpath = $this->config['model_path'];
        $this->modx->addPackage('versionx',$modelpath);
        $this->modx->lexicon->load('versionx:default');
    }

    /**
     * @param string $ctx Context name
     * @return bool
     */
    public function initialize($ctx = 'web') {
        switch ($ctx) {
            case 'mgr':

            break;
        }
        return true;
    }

    /* getChunk & _GetTplChunk by splittingred */
    /**
    * Gets a Chunk and caches it; also falls back to file-based templates
    * for easier debugging.
    *
    * @access public
    * @param string $name The name of the Chunk
    * @param array $properties The properties for the Chunk
    * @return string The processed content of the Chunk
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
    * @return modChunk/boolean Returns the modChunk object if found, otherwise
    * false.
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
     * Creates a new version of a Resource.
     *
     * @param \modResource $resource
     * @param string $mode
     * @return bool
     *
     */
    public function newResourceVersion(modResource $resource, $mode = 'upd') {
        if (!($resource instanceof modResource)) { return false; }

        // We're retrieving the resource again to clean up raw post data we don't want.
        $resource = $this->modx->getObject('modResource',$resource->get('id'));

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
            'content' => $resource->getContent(),
        );

        $version->fromArray($v);

        unset ($rArray['id'],$rArray['content']);
        $version->set('fields',$rArray);

        /* Check if $resource->getTemplateVars exists, as it's 2.1+ only. If it doesn't, do nothing for now. */
        if (method_exists($resource,'getTemplateVars'))
            $tvs = $resource->getTemplateVars();
        else
            $tvs = array();

        $tvArray = array();
        foreach ($tvs as $tv) {
            $tvArray[] = $tv->get(array('id','value'));
        }
        $version->set('tvs',$tvArray);

        return $version->save();
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

        return $version->save();
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

        return $version->save();
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

        return $version->save();
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

        return $version->save();
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

        return $version->save();
    }

    /**
     * Gets & prepares version details for output.
     *
     * @param string $class
     * @param int $id
     * @param bool $json
     * @param string $prefix
     * @return false|array
     */
    public function getVersionDetails($class = 'vxResource',$id = 0, $json = false, $prefix = '') {
        $v = $this->modx->getObject($class,$id);
        /* @var xPDOObject $v */
        if ($v instanceof $class) {
            $vArray = $v->toArray();
            $vArray['mode'] = $this->modx->lexicon('versionx.mode.'.$vArray['mode']);

            /* Resource specific processing */
            if ($class == 'vxResource') {
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

                $vArray['content'] = nl2br(htmlentities($vArray['content']));

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
                    if (!$this->tvs[$tv['id']]) {
                        $tvObj = $this->modx->getObject('modTemplateVar',$tv['id']);
                        if ($tvObj instanceof modTemplateVar) {
                            $this->tvs[$tv['id']] = $tvObj->get('caption');
                        }
                    }
                    $tvArray[] = array_merge($tv,array('caption' => $this->tvs[$tv['id']]));
                }
                $vArray['tvs'] = $tvArray;
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

}
?>