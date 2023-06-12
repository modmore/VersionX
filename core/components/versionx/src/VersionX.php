<?php

namespace modmore\VersionX;

use modmore\VersionX\Types\Type;
use MODX\Revolution\modCategory;
use MODX\Revolution\modChunk;
use MODX\Revolution\modPlugin;
use MODX\Revolution\modSnippet;
use MODX\Revolution\modTemplate;
use MODX\Revolution\modTemplateVarResource;
use MODX\Revolution\modX;

// Set aliases for MODX 2.x <-> 3.x compatibility
if (class_exists(modTemplateVarResource::class)) {
    class_alias(modTemplateVarResource::class, \modTemplateVarResource::class);
}
if (class_exists(modTemplate::class)) {
    class_alias(modTemplate::class, \modTemplate::class);
}
if (class_exists(modChunk::class)) {
    class_alias(modChunk::class, \modChunk::class);
}
if (class_exists(modPlugin::class)) {
    class_alias(modPlugin::class, \modPlugin::class);
}
if (class_exists(modSnippet::class)) {
    class_alias(modSnippet::class, \modSnippet::class);
}

class VersionX {
    public $modx;
    protected ?DeltaManager $deltaManager = null;
    public array $config = [];
    public bool $debug = false;
    public string $charset;
    public const CACHE_OPT = [
        'cache_key' => 'versionx',
    ];
    public const CORE_TYPES = [
        \modmore\VersionX\Types\Resource::class,
        \modmore\VersionX\Types\Template::class,
        \modmore\VersionX\Types\Chunk::class,
        \modmore\VersionX\Types\Snippet::class,
        \modmore\VersionX\Types\Plugin::class,
        \modmore\VersionX\Types\TV::class,
    ];

    /**
     * @param \modX|modX $modx
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
    }

    public function deltas(): DeltaManager
    {
        if (!$this->deltaManager) {
            $this->deltaManager = new DeltaManager($this);
        }
        return $this->deltaManager;
    }

    /**
     * Runs the loadCustomPackage() method from each custom type class listed in the 'versionx.custom_type_classes'
     * system setting.
     * The loadCustomPackage() method can be used to load a package, display custom objects and revert changes via the
     * main grid.
     * @return void
     */
    public function loadCustomClasses(): void
    {
        $json = $this->modx->getOption('versionx.custom_type_classes');
        if (empty($json)) {
            return;
        }

        $array = json_decode($json, true);

        foreach ($array as $item) {
            // Check for {core_path} placeholder and replace with actual path
            $item['path'] = str_replace('{core_path}', MODX_CORE_PATH, $item['path']);

            // Ignore if file doesn't exist at provided path
            if (!file_exists($item['path'])) {
                $this->modx->log(MODX_LOG_LEVEL_ERROR, "[VersionX] Custom type class missing at {$item['path']}");
                continue;
            }

            require_once $item['path'];
            if (!$item['class']::loadCustomPackage($this->modx)) {
                $this->modx->log(MODX_LOG_LEVEL_ERROR,
                    "[VersionX] Custom type class {$item['class']} failed to load the custom package.");
            }
        }
    }

    /**
     * Outputs the JavaScript needed to add a tab to the panels.
     *
     * @param int $id
     * @param Type $type
     * @throws \Exception
     */
    public function outputVersionsTab (int $id, Type $type): void
    {
        $langs = $this->_getLangs();
        $jsUrl = $this->config['js_url'] . 'mgr/';
        $cssUrl = $this->config['css_url'] . 'mgr/mgr.css';

        $this->modx->regClientStartupScript($jsUrl . 'versionx.class.js');
        $this->modx->regClientStartupHTMLBlock('
            <link href="'. $cssUrl .'" rel="stylesheet">
            <script type="text/javascript">
                VersionX.config = ' . json_encode($this->config) . ';
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
                'panel_id' => $type->getPanelId(),
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