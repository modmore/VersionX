<?php

namespace modmore\VersionX;

class Utils {
    /**
     * @param string $className
     * @param string $package
     * @return string
     */
    public static function getTabId(string $className = 'modResource', string $package = 'modx'): string
    {
        switch ($className) {
            case 'modResource':
                return 'modx-resource-tabs';

            case 'modTemplateVar':
                return 'modx-tv-tabs';

            case 'modChunk':
                return 'modx-chunk-tabs';

            case 'modSnippet':
                return 'modx-snippet-tabs';

            case 'modTemplate':
                return 'modx-template-tabs';

            case 'modPlugin':
                return 'modx-plugin-tabs';

            default:
                return strtolower($package . '-' . $className) . '-tabs';
        }
    }

    /**
     * Flattens an array recursively.
     * @param mixed $array
     *
     * @return string
     */
    public static function flattenArray($array = []): string
    {
        if (!is_array($array)) return (string)$array;

        $string = [];
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $value = '{' . self::flattenArray($value) .'}';
            }
            if (!empty($value)) {
                $string[] = $key . ':' . $value;
            }
        }
        return implode(',', $string);
    }

}