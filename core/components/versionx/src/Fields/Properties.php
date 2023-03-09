<?php

namespace modmore\VersionX\Fields;

class Properties extends Field
{
    public function parse()
    {
        if (is_array($this->value)) {
            $this->value = self::splitPropertyValues($this->value, $this->fieldName);
        }
    }

    /**
     * @param array $arrayField
     * @param string $name
     * @param array $fields
     * @return array
     */
    public static function splitPropertyValues(array $arrayField, string $name = '', array &$fields = []): array
    {
        $arrays = [];
        foreach ($arrayField as $field => $value) {
            if (is_numeric($field)) {
                $fields[$name][$field] = $value;
                continue;
            }
            if (!is_array($value)) {
                $fields["{$name}.{$field}"] = $value;
                continue;
            }

            $arrays[$field] = $value;
        }

        foreach ($arrays as $field => $value) {
            self::splitPropertyValues($value, "{$name}.{$field}", $fields);
        }

        return $fields;
    }

    /**
     * @param \vxDeltaField $field
     * @param mixed $data
     * @return mixed
     */
    public static function revertPropertyValue(\vxDeltaField $field, &$data)
    {
        $pieces = explode('.', $field->get('field'));
        $last = end($pieces);
        foreach ($pieces as $piece) {
            if (!is_array($data) || !array_key_exists($piece, $data)) {
                continue;
            }

            if ($piece === $last) {
                $data[$piece] = $field->get('before');
            }
            else {
                $data = &$data[$piece];
            }
        }

        return $data;
    }

}