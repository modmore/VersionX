<?php

namespace modmore\VersionX;

class Tab {
    public static $tabJavascript = [
        'resources/grid.versions.js',
    ];

    public static $tabTpl = 'mgr/tab';

    /**
     * Gets the Javascript filenames that are required for tabs.
     * @static
     * @return array
     */
    public static function getTabJavascript() {
        return self::$tabJavascript;
    }

    /**
     * Gets the tab template file name.
     * @static
     * @return string
     */
    public static function getTabTpl() {
        return self::$tabTpl;
    }
}