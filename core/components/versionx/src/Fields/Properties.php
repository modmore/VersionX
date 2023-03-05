<?php

namespace modmore\VersionX\Fields;

class Properties extends Field
{
    public function parse()
    {
        $this->value = $this->splitPropertyValues($this->value, $this->fieldName);
    }

    /**
     * @param array $arrayField
     * @param string $name
     * @param array $fields
     * @return array
     */
    public function splitPropertyValues(array $arrayField, string $name = '', array &$fields = []): array
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
            $this->splitPropertyValues($value, "{$name}.{$field}", $fields);
        }

        return $fields;
    }
}