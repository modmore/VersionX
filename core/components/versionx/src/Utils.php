<?php

namespace modmore\VersionX;

class Utils {

    /**
     * Flattens an array recursively, and returns other values as a string
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