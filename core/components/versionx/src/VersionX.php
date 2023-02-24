<?php

namespace modmore\VersionX;

use modmore\VersionX\Types\Type;
use xPDO\xPDOException;

class VersionX {
    public $modx;
    protected ?DeltaManager $deltaManager = null;
    private array $chunks = [];
    private array $tvs = [];
    public array $config = [];
    public array $categoryCache = [];
    public bool $debug = false;
    public string $charset;

    /**
     * @param \modX|\MODX\Revolution\modX $modx
     * @param array $config
     */
    public function __construct($modx,array $config = []) {
        $this->modx = $modx;

        $basePath = $this->modx->getOption('versionx.core_path', $config,
            $this->modx->getOption('core_path') . 'components/versionx/');
        $assetsUrl = $this->modx->getOption('versionx.assets_url', $config,
            $this->modx->getOption('assets_url') . 'components/versionx/');
        $assetsPath = $this->modx->getOption('versionx.assets_path', $config,
            $this->modx->getOption('assets_path') . 'components/versionx/');

        $this->config = array_merge([
            'base_bath' => $basePath,
            'core_path' => $basePath,
            'model_path' => $basePath.'model/',
            'processors_path' => $basePath.'processors/',
            'elements_path' => $basePath.'elements/',
            'templates_path' => $basePath.'templates/',
            'assets_path' => $assetsPath,
            'js_url' => $assetsUrl . 'js/',
            'css_url' => $assetsUrl . 'css/',
            'assets_url' => $assetsUrl,
            'connector_url' => $assetsUrl.'connector.php',
            'has_users_permission' => $this->modx->hasPermission('view_user'),
        ], $config);

        // Set version
        require_once dirname(__DIR__) . '/docs/version.inc.php';
        if (defined('VERSIONX_FULLVERSION')) {
            $this->config['version'] = VERSIONX_FULLVERSION;
        }

        // Load model
        $modelPath = $this->config['model_path'];
        $this->modx->addPackage('versionx', $modelPath);

        // Load lexicons
        $this->modx->lexicon->load('versionx:default');

        // Set debug mode
        $this->debug = $this->modx->getOption('versionx.debug',null,false);
    }

    public function deltas(): DeltaManager
    {
        if (!$this->deltaManager) {
            $this->deltaManager = new DeltaManager($this->modx);
        }
        return $this->deltaManager;
    }

//    /**
//     * @param $class
//     * @param $contentId
//     * @param $mode
//     * @return bool
//     * @deprecated
//     */
//    public function newVersionFor($class, $contentId, $mode)
//    {
//        switch ($class) {
//            case 'vxResource':
//                return $this->newResourceVersion($contentId, $mode);
//
//            case 'vxTemplate':
//                return $this->newTemplateVersion($contentId, $mode);
//
//            case 'vxChunk':
//                return $this->newChunkVersion($contentId, $mode);
//
//            case 'vxSnippet':
//                return $this->newSnippetVersion($contentId, $mode);
//
//            case 'vxPlugin':
//                return $this->newPluginVersion($contentId, $mode);
//
//            case 'vxTemplateVar':
//                return $this->newTemplateVarVersion($contentId, $mode);
//        }
//        $this->modx->log(\modX::LOG_LEVEL_ERROR, 'Call to ' . __METHOD__ . ' with unrecognised class ' . $class);
//        return false;
//    }

//    /**
//     * Creates a new version of a Resource.
//     *
//     * @param int|\modResource|\MODX\Revolution\modResource $resource
//     * @param string $mode
//     * @return bool
//     *
//     * @deprecated
//     */
//    public function newResourceVersion($resource, $mode = 'upd') {
//        if ($resource instanceof \MODX\Revolution\modResource || $resource instanceof \modResource) {
//            // We're retrieving the resource again to clean up raw post data we don't want.
//            $resource = $this->modx->getObject('modResource',$resource->get('id'));
//        } else {
//            $resource = $this->modx->getObject('modResource',(int)$resource);
//        }
//
//        $rArray = $resource->toArray();
//
//        /* @var \vxResource $version */
//        $version = $this->modx->newObject('vxResource');
//
//        $v = array(
//            'content_id' => $rArray['id'],
//            'user' => $this->modx->user->get('id'),
//            'mode' => $mode,
//            'title' => (empty($rArray[$this->modx->getOption('resource_tree_node_name')]) ? $rArray['pagetitle'] : $rArray[$this->modx->getOption('resource_tree_node_name')]),
//            'context_key' => $rArray['context_key'],
//            'class' => $rArray['class_key'],
//            'content' => $resource->get('content'),
//        );
//
//        $version->fromArray($v);
//
//        unset ($rArray['id'],$rArray['content']);
//        $version->set('fields',$rArray);
//
//        $tvs = $resource->getTemplateVars();
//        $tvArray = array();
//        /* @var \MODX\Revolution\modTemplateVar|\modTemplateVar $tv */
//        foreach ($tvs as $tv) {
//            $tvArray[] = $tv->get(array('id','value'));
//        }
//        $version->set('tvs',$tvArray);
//
//        if($this->checkLastVersion('vxResource', $version)) {
//            return $version->save();
//        }
//        return true;
//    }


//    /**
//     * Creates a new version of a Template.
//     *
//     * @param int|\MODX\Revolution\modTemplate|\modTemplate $template
//     * @param string $mode
//     * @return bool
//     *
//     * @deprecated
//     */
//    public function newTemplateVersion($template, $mode = 'upd') {
//        if ($template instanceof \MODX\Revolution\modTemplate || $template instanceof \modTemplate) {
//            /* Fetch it again to prevent getting stuck with raw post data */
//            $template = $this->modx->getObject('modTemplate', $template->get('id'));
//        } else {
//            $template = $this->modx->getObject('modTemplate', (int)$template);
//        }
//        $tArray = $template->toArray();
//
//        /* @var \vxTemplate $version */
//        $version = $this->modx->newObject('vxTemplate');
//
//        $v = array(
//            'content_id' => $tArray['id'],
//            'user' => $this->modx->user->get('id'),
//            'mode' => $mode,
//        );
//
//        $version->fromArray(array_merge($v,$tArray));
//
//        if($this->checkLastVersion('vxTemplate', $version)) {
//            return $version->save();
//        }
//        return true;
//    }

//
//    /**
//     * Creates a new version of a Template Variable.
//     *
//     * @param int|\MODX\Revolution\modTemplateVar|\modTemplateVar $tv
//     * @param string $mode
//     * @return bool
//     *
//     * @deprecated
//     */
//    public function newTemplateVarVersion($tv, $mode = 'upd') {
//        if ($tv instanceof \MODX\Revolution\modTemplateVar || $tv instanceof \modTemplateVar) {
//            /* Fetch it again to prevent getting stuck with raw post data */
//            $tv = $this->modx->getObject('modTemplateVar', $tv->get('id'));
//        } else {
//            $tv = $this->modx->getObject('modTemplateVar', (int)$tv);
//        }
//
//        $tArray = $tv->toArray();
//
//        /* @var \vxTemplateVar $version */
//        $version = $this->modx->newObject('vxTemplateVar');
//
//        $v = array(
//            'content_id' => $tArray['id'],
//            'user' => $this->modx->user->get('id'),
//            'mode' => $mode,
//        );
//
//        $version->fromArray(array_merge($v,$tArray));
//
//        if($this->checkLastVersion('vxTemplateVar', $version)) {
//            return $version->save();
//        }
//        return true;
//    }
//
//    /**
//     * Create a new version of a Chunk.
//     *
//     * @param int|\MODX\Revolution\modChunk|\modChunk $chunk
//     * @param string $mode
//     * @return bool
//     * @deprecated
//     */
//    public function newChunkVersion($chunk, $mode = 'upd') {
//        if ($chunk instanceof \MODX\Revolution\modChunk || $chunk instanceof \modChunk) {
//            /* Fetch it again to prevent getting stuck with raw post data */
//            $chunk = $this->modx->getObject('modChunk', $chunk->get('id'));
//        } else {
//            $chunk = $this->modx->getObject('modChunk', (int)$chunk);
//        }
//
//        // prevents resource groups from failing in MODX versions prior to 2.2.14 (see github #8992 + fix)
//        if (!($chunk instanceof \modChunk) && !($chunk instanceof \MODX\Revolution\modChunk)) {
//            return false;
//        }
//
//        $cArray = $chunk->toArray();
//
//        /* @var \vxChunk $version */
//        $version = $this->modx->newObject('vxChunk');
//
//        $v = array(
//            'content_id' => $cArray['id'],
//            'user' => $this->modx->user->get('id'),
//            'mode' => $mode,
//        );
//
//        $version->fromArray(array_merge($v,$cArray));
//
//        if($this->checkLastVersion('vxChunk', $version)) {
//            return $version->save();
//        }
//        return true;
//    }
//
//    /**
//     * Creates a new version of a Snippet.
//     *
//     * @param int|\MODX\Revolution\modSnippet|\modSnippet $snippet
//     * @param string $mode
//     * @return bool
//     * @deprecated
//     */
//    public function newSnippetVersion($snippet, $mode = 'upd') {
//        if ($snippet instanceof \MODX\Revolution\modSnippet || $snippet instanceof \modSnippet) {
//            /* Fetch it again to prevent getting stuck with raw post data */
//            $snippet = $this->modx->getObject('modSnippet', $snippet->get('id'));
//        } else {
//            $snippet = $this->modx->getObject('modSnippet', (int)$snippet);
//        }
//
//        $sArray = $snippet->toArray();
//
//        /* @var \vxSnippet $version */
//        $version = $this->modx->newObject('vxSnippet');
//
//        $v = array(
//            'content_id' => $sArray['id'],
//            'user' => $this->modx->user->get('id'),
//            'mode' => $mode,
//        );
//
//        $version->fromArray(array_merge($v,$sArray));
//
//        if($this->checkLastVersion('vxSnippet', $version)) {
//            return $version->save();
//        }
//        return true;
//    }
//
//    /**
//     * Creates a new version of a Plugin.
//     *
//     * @param int|\MODX\Revolution\modPlugin|\modPlugin $plugin
//     * @param string $mode
//     * @return bool
//     * @deprecated
//     */
//    public function newPluginVersion($plugin, $mode = 'upd') {
//        if ($plugin instanceof \MODX\Revolution\modPlugin || $plugin instanceof \modPlugin) {
//            /* Fetch it again to prevent getting stuck with raw post data */
//            $plugin = $this->modx->getObject('modPlugin', $plugin->get('id'));
//        } else {
//            $plugin = $this->modx->getObject('modPlugin', (int)$plugin);
//        }
//        $pArray = $plugin->toArray();
//
//        /* @var \vxPlugin $version */
//        $version = $this->modx->newObject('vxPlugin');
//
//        $v = array(
//            'content_id' => $pArray['id'],
//            'user' => $this->modx->user->get('id'),
//            'mode' => $mode,
//        );
//
//        $version->fromArray(array_merge($v,$pArray));
//
//        if($this->checkLastVersion('vxPlugin', $version)) {
//            return $version->save();
//        }
//        return true;
//    }

//    /**
//     * Gets & prepares version details for output.
//     *
//     * @param string $class
//     * @param int $id
//     * @param bool $json
//     * @param string $prefix
//     * @return bool|array
//     * @deprecated
//     */
//    public function getVersionDetails($class = 'vxResource',$id = 0, $json = false, $prefix = '') {
//        $v = $this->modx->getObject($class, ['version_id' => $id]);
//        /* @var \xPDOObject $v */
//        if ($v instanceof $class) {
//            $vArray = $v->toArray();
//            $vArray['mode'] = $this->modx->lexicon('versionx.mode.'.$vArray['mode']);
//
//            /* Class specific processing */
//            switch ($class) {
//                case 'vxResource':
//                    $vArray = array_merge($vArray,$vArray['fields']);
//
//                    if ($vArray['parent'] != 0) {
//                        /* @var \modResource $parent */
//                        $parent = $this->modx->getObject('modResource',$vArray['parent']);
//                        if ($parent instanceof \modResource) $vArray['parent'] = $parent->get('pagetitle') .' ('.$vArray['parent'].')';
//                    }
//
//                    /* Process content type */
//                    /* @var \MODX\Revolution\modContentType|\modContentType $ct */
//                    $ct = $this->modx->getObject('modContentType',$vArray['content_type']);
//                    if ($ct instanceof \MODX\Revolution\modContentType || $ct instanceof \modContentType) {
//                        $vArray['content_type'] = $ct->get('name');
//                    }
//
//                    $vArray['content'] = $this->_prepareCodeView($vArray['content']);
//
//                    if ($vArray['content_dispo'] == 1) {
//                        $vArray['content_dispo'] = $this->modx->lexicon('attachment');
//                    }
//                    else {
//                        $vArray['content_dispo'] = $this->modx->lexicon('inline');
//                    }
//
//                    /* Process boolean values */
//                    $vArray['published'] = (intval($vArray['published'])) ? $this->modx->lexicon('yes') : $this->modx->lexicon('no');
//                    $vArray['hidemenu'] = (intval($vArray['hidemenu'])) ? $this->modx->lexicon('yes') : $this->modx->lexicon('no');
//                    $vArray['isfolder'] = (intval($vArray['isfolder'])) ? $this->modx->lexicon('yes') : $this->modx->lexicon('no');
//                    $vArray['richtext'] = (intval($vArray['richtext'])) ? $this->modx->lexicon('yes') : $this->modx->lexicon('no');
//                    $vArray['searchable'] = (intval($vArray['searchable'])) ? $this->modx->lexicon('yes') : $this->modx->lexicon('no');
//                    $vArray['cacheable'] = (intval($vArray['cacheable'])) ? $this->modx->lexicon('yes') : $this->modx->lexicon('no');
//                    $vArray['deleted'] = (intval($vArray['deleted'])) ? $this->modx->lexicon('yes') : $this->modx->lexicon('no');
//
//                    /* Process time stamps */
//                    $df = $this->modx->config['manager_date_format'].' '.$this->modx->config['manager_time_format'];
//                    $vArray['saved'] = ($vArray['saved'] != 0) ? date($df,strtotime($vArray['saved'])) : '';
//                    $vArray['publishedon'] = ($vArray['publishedon'] != 0) ? date($df,strtotime($vArray['publishedon'])) : '';
//                    $vArray['pub_date'] = ($vArray['pub_date'] != 0) ? date($df,strtotime($vArray['pub_date'])) : '';
//                    $vArray['unpub_date'] = ($vArray['unpub_date'] != 0) ? date($df,strtotime($vArray['unpub_date'])) : '';
//
//                    /* Get TV captions */
//                    $tvArray = array();
//                    foreach ($vArray['tvs'] as $tv) {
//                        if (!isset($this->tvs[$tv['id']]) || empty($this->tvs[$tv['id']])) {
//                            /* @var \MODX\Revolution\modTemplateVar|\modTemplateVar $tvObj */
//                            $tvObj = $this->modx->getObject('modTemplateVar',$tv['id']);
//                            if ($tvObj instanceof \MODX\Revolution\modTemplateVar || $tvObj instanceof \modTemplateVar) {
//                                $caption = $tvObj->get('caption');
//                                if (empty($caption)) {
//                                    $caption = $tvObj->get('name');
//                                }
//                                $this->tvs[$tv['id']] = $caption;
//                            } else {
//                                $this->tvs[$tv['id']] = 'tv'.$tv['id'];
//                            }
//                        }
//                        $tvArray[] = array_merge($tv,array('caption' => $this->tvs[$tv['id']]));
//                    }
//                    $vArray['tvs'] = $tvArray;
//                    break;
//                case 'vxTemplateVar':
//                    $vArray['category'] = $this->getCategory($vArray['category']);
//                    if (is_array($vArray['input_properties'])) {
//                        foreach ($vArray['input_properties'] as $key => $value) {
//                            if ($decoded = $this->modx->fromJSON($value)) {
//                                $vArray['input_properties'][$key] = $decoded;
//                            }
//                        }
//                    }
//                    if (is_array($vArray['output_properties'])) {
//                        foreach ($vArray['output_properties'] as $key => $value) {
//                            if ($decoded = $this->modx->fromJSON($value)) {
//                                $vArray['output_properties'][$key] = $decoded;
//                            }
//                        }
//                    }
//                    break;
//
//                case 'vxTemplate':
//                    $vArray['content'] =  $this->_prepareCodeView($vArray['content']);
//                    $vArray['category'] = $this->getCategory($vArray['category']);
//                    break;
//
//                case 'vxChunk':
//                case 'vxSnippet':
//                    $vArray['snippet'] =  $this->_prepareCodeView($vArray['snippet']);
//                    $vArray['category'] = $this->getCategory($vArray['category']);
//                    break;
//
//                case 'vxPlugin':
//                    $vArray['plugincode'] =  $this->_prepareCodeView($vArray['plugincode']);
//                    $vArray['category'] = $this->getCategory($vArray['category']);
//                    break;
//            }
//
//            /* @var \MODX\Revolution\modUserProfile|\modUserProfile $up */
//            $up = $this->modx->getObject('modUserProfile',array('internalKey' => $vArray['user']));
//            if ($up instanceof \MODX\Revolution\modUserProfile || $up instanceof \modUserProfile) {
//                $vArray['user'] = $up->get('fullname');
//            }
//
//            if (!empty($prefix)) {
//                $ta = array();
//                foreach ($vArray as $tk => $tv) {
//                    $ta[$prefix.$tk] = $tv;
//                }
//                $vArray = $ta;
//            }
//            if ($json) {
//                return json_encode($vArray);
//            }
//            return $vArray;
//        }
//        return false;
//    }
//
//    /**
//     * @param $string
//     *
//     * @return string
//     */
//    private function _prepareCodeView($string): string
//    {
//        $lines = explode("\n",$string);
//        foreach ($lines as $idx => $line) {
//            $pos = 0;
//            while( substr($line, $pos, 1) == ' ') {
//                $pos++;
//            }
//            $lines[$idx] = str_repeat('&nbsp;', $pos) . $this->htmlent(substr($line, $pos));
//        }
//
//        $lines = implode("<br />\n", $lines);
//        return $lines;
//    }
//
//    /**
//     * Checks the last saved version (if any).
//     * Returns true if there is no earlier version, or something is different.
//     * So if this returns true: go ahead and save the version.
//     * If this returns false: nothing changed, don't bother.
//     *
//     * @param string $class
//     * @param \xPDOObject $version
//     *
//     * @return bool
//     * @deprecated
//     */
//    protected function checkLastVersion(string $class, \xPDOObject $version): bool
//    {
//        /* Get last version to make sure we've got some changes to save */
//        $c = $this->modx->newQuery($class);
//        $c->where(array('content_id' => $version->get('content_id')));
//        $c->sortby('version_id','DESC');
//        $c->limit(1);
//
//        $lastVersion = $this->modx->getCollection($class,$c);
//        $lastVersion = !empty($lastVersion) ? array_shift($lastVersion) : array();
//        /* @var \vxResource $lastVersion */
//
//        /* If there's no earlier version, we can go ahead and
//         return true to indicate we need to save the version */
//        if (!($lastVersion instanceof $class)) {
//            if ($this->debug) $this->modx->log(\xPDO::LOG_LEVEL_ERROR,"[VersionX] Saving a {$class} for ID {$version->get('content_id')}: No earlier version found.");
//            return true;
//        }
//
//        $newVersionArray = $version->toArray();
//        $lastVersionArray = $lastVersion->toArray();
//
//        /* Get rid of excluded vars for the specific object. */
//        $exclude = call_user_func(array($class,'getExcludeFields'));
//        if ($this->debug) $this->modx->log(\modX::LOG_LEVEL_ERROR,'[VersionX checkLastVersion] Exclude fields: ' . print_r($exclude, true));
//        foreach ($exclude as $key => $value) {
//            if (is_array($value)) {
//                foreach ($value as $subfield) {
//                    if (isset($newVersionArray[$key]) && isset($newVersionArray[$key][$subfield])) {
//                        unset ($newVersionArray[$key][$subfield]);
//                    }
//                    if (isset($lastVersionArray[$key]) && isset($lastVersionArray[$key][$subfield])) {
//                        unset ($lastVersionArray[$key][$subfield]);
//                    }
//                }
//            } else {
//                if (isset($lastVersionArray[$value])) { unset($lastVersionArray[$value]); }
//                if (isset($newVersionArray[$value])) { unset($newVersionArray[$value]); }
//            }
//        }
//
//        $newVersionFlat = Utils::flattenArray($newVersionArray);
//        $lastVersionFlat = Utils::flattenArray($lastVersionArray);
//
//        if ($this->debug) {
//            $this->modx->log(\modX::LOG_LEVEL_ERROR,'[VersionX checkLastVersion] New: ' . print_r($newVersionArray, true));
//            $this->modx->log(\modX::LOG_LEVEL_ERROR,'[VersionX checkLastVersion] New Flattened: ' . $newVersionFlat);
//            $this->modx->log(\modX::LOG_LEVEL_ERROR,'[VersionX checkLastVersion] Last: ' . print_r($lastVersionArray, true));
//            $this->modx->log(\modX::LOG_LEVEL_ERROR,'[VersionX checkLastVersion] Last Flattened: ' . $newVersionFlat);
//        }
//
//        /* If the flattened arrays don't match there's a difference and we return true to indicate we need to save. */
//        if ($newVersionFlat != $lastVersionFlat) {
//            return true;
//        }
//
//        if ($this->debug) $this->modx->log(\xPDO::LOG_LEVEL_ERROR,"[VersionX] Not saving a {$class} for ID {$version->get('content_id')}: No changes found.");
//        /* If we got here, there was a last version but it seemed nothing changes.
//        Return false to indicate to NOT save a new version. */
//        return false;
//    }

    /**
     * Outputs the JavaScript needed to add a tab to the panels.
     *
     * @param int $id
     * @param Type $type
     * @param string $package
     * @throws \Exception
     */
    public function outputVersionsTab (int $id, Type $type, string $package = 'modx'): void
    {
        $path = $this->config['model_path'] . 'versionx/vxdelta.class.php';
        if (file_exists($path)) {
            require_once ($path);
        }

        $langs = $this->_getLangs();
        $jsUrl = $this->config['js_url'] . 'mgr/';
        $cssUrl = $this->config['css_url'] . 'mgr/mgr.css';


        // Load class & set inVersion to true, indicating we're not looking at the VersionX controller.
        $this->modx->regClientStartupScript($jsUrl . 'versionx.class.js');
        $this->modx->regClientStartupHTMLBlock('
            <link href="'. $cssUrl .'" rel="stylesheet">
            <script type="text/javascript">
                VersionX.config = ' . json_encode($this->config) . ';
                VersionX.inVersion = true;
                ' . $langs . '
            </script>
        ');

        // Get the different individual JS files to add to the page
        $tabJs = $type->getTabJavascript();
        foreach ($tabJs as $js) {
            $this->modx->regClientStartupScript($jsUrl . $js);
        }

        // Get the template and register it
        $tplName = $type->getTabTpl();
        $tplFile = $this->config['templates_path'] . $tplName . '.tpl';
        if (file_exists($tplFile)) {
            $this->modx->smarty->assign([
                'tabs_component_id' => $type->getTabId(),
                'principal_package' => $type->getPackage(),
                'principal_class' => str_replace('\\','\\\\', $type->getClass()),
                'principal' => $id,
                'type' => str_replace('\\','\\\\', get_class($type)),
            ]);
            $tpl = $this->modx->smarty->fetch($tplFile);
            if (!empty($tpl)) {
                $this->modx->regClientStartupHTMLBlock($tpl);
            }
        }
    }

    /**
     * Gets language strings for use on non-VersionX controllers.
     * @return string
     */
    public function _getLangs(): string
    {
        $entries = $this->modx->lexicon->loadCache('versionx');
        return 'Ext.applyIf(MODx.lang,' . json_encode($entries) . ');';
    }

    /**
     * @param $id
     *
     * @return string
     */
    public function getCategory($id): string
    {
        if (!$id || $id == 0) return '';
        if (isset($this->categoryCache[$id])) {
            return $this->categoryCache[$id];
        }
        /* @var \MODX\Revolution\modCategory|\modCategory $category */
        $category = $this->modx->getObject('modCategory',(int)$id);
        if ($category) {
            return $this->categoryCache[$id] = $category->get('category') . " ($id)";
        } else {
            return (string)$id;
        }
    }

    /**
     * Runs htmlentities() on the string with the proper character encoding.
     * @param string $string
     * @return string
     */
    public function htmlent($string = ''): string
    {
        if (!isset($this->charset)) {
            $this->charset = $this->modx->getOption('modx_charset', null, 'UTF-8');
        }
        return htmlentities($string, ENT_QUOTES | ENT_SUBSTITUTE, $this->charset);
    }
}

