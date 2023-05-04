<?php

namespace modmore\VersionX\Types;

use modmore\VersionX\Fields\Field;
use modmore\VersionX\Fields\Properties;
use modmore\VersionX\VersionX;

abstract class Type
{
    public \modX $modx;
    public VersionX $versionX;

    /**
     * @var string $class
     * The name of the class that is being versioned
     */
    protected string $class = '';

    /**
     * @var string $package
     * The name of your custom package
     */
    protected string $package = 'core';

    /**
     * @var string $tabTpl
     * The path to the template file used when loading a tab on an object
     */
    protected string $tabTpl = 'mgr/tab';

    /**
     * @var string
     */
    protected string $panelId = 'modx-resource-panel';

    /**
     * @var string $nameField
     * The "human-readable" field used to identify the object.
     */
    protected string $nameField = '';

    /**
     * @var array $tabJavaScript
     * An array of file names that should be included when loading a VersionX tab on an object
     */
    protected array $tabJavaScript = [
        'window.milestone.js',
        'grid.deltas.js',
    ];

    /**
     * @var array $excludedFields
     * List fields that should not be versioned. A common example might be "editedon" since that changes every save.
     */
    protected array $excludedFields = [
        'id',
    ];

    /**
     * @var array $fieldOrder
     * List any fields here that should come first in the diff. Those not listed will still be included in the
     * order they're loaded.
     */
    protected array $fieldOrder = [];

    function __construct(VersionX $versionX)
    {
        $this->modx = $versionX->modx;
        $this->versionX = $versionX;
    }

    /**
     * @return string
     */
    public function getPackage(): string
    {
        return $this->package;
    }

    /**
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }

    /**
     * @return string
     */
    public function getTabTpl(): string
    {
        return $this->tabTpl;
    }

    /**
     * @return string
     */
    public function getTabId(): string
    {
        return $this->tabId;
    }

    /**
     * @return string
     */
    public function getPanelId(): string
    {
        return $this->panelId;
    }

    /**
     * @return array
     */
    public function getTabJavascript(): array
    {
        return $this->tabJavaScript;
    }

    /**
     * @return array
     */
    public function getExcludedFields(): array
    {
        return $this->excludedFields;
    }

    /**
     * @return string
     */
    public function getNameField(): string
    {
        return $this->nameField;
    }

    /**
     * @return array
     */
    public function getFieldOrder(): array
    {
        return $this->fieldOrder;
    }

    /**
     * Any field not specified as a special class is treated as default text
     * @var array
     */
    protected array $fieldClassMap = [];

    /**
     * Runs before a delta is created. Return false to prevent creation.
     * @param string $time - Delta create time
     * @param \xPDOObject $object - The object to be versioned
     * @return bool
     */
    public function beforeDeltaCreate(string $time, \xPDOObject $object): bool
    {
        return true;
    }

    /**
     * Opportunity to add additional \vxDeltaField objects to the array. For example, adding TV values when saving
     * a resource.
     * @param \vxDeltaField[] $fields
     * @param array $prevFields
     * @param \xPDOObject $object
     * @return \vxDeltaField[]
     */
    public function includeFieldsOnCreate(array $fields, array $prevFields, \xPDOObject $object): array
    {
        return $fields;
    }

    /**
     * Runs after a delta has been created for an object
     * @param \vxDelta $delta - The newly created delta
     * @param \xPDOObject $object - The versioned object
     * @return \vxDelta|null
     */
    public function afterDeltaCreate(\vxDelta $delta, \xPDOObject $object): ?\vxDelta
    {
        return $delta;
    }

    /**
     * Runs before object being reverted is saved.
     * @param string $action - 'all', 'delta', or 'single'
     * @param array $fields - the delta fields that are being saved to the object
     * @param \xPDOObject $object - the object being reverted
     * @param string $now
     * @param string|null $deltaTimestamp
     * @return \xPDOObject
     */
    public function afterRevert(string $action, array $fields, \xPDOObject $object, string $now, string $deltaTimestamp = null): \xPDOObject
    {
        foreach ($fields as $field) {
            $this->savePropertiesFields($field, $object);
        }

        return $object;
    }

    /**
     * Sets a field name to a specialised field class to handle different format or rendering
     * @param string $name
     * @param Field $fieldClass
     * @return void
     */
    public function registerFieldClass(string $name, Field $fieldClass)
    {
        $this->fieldClassMap[$name] = $fieldClass;
    }

    /**
     * Looks up a matching field type class by column name
     * @param string $field
     * @return mixed|string
     */
    public function getFieldClass(string $field)
    {
        if (strpos($field, '.') !== false) {
            $field = explode('.', $field)[0];
        }

        if (array_key_exists($field, $this->fieldClassMap)) {
            return $this->fieldClassMap[$field];
        }

        return \modmore\VersionX\Fields\Text::class;
    }

    /**
     * Gets the values from an object, optionally including extra fields
     * @param \xPDOObject $object
     * @param array $extraFields
     * @return array
     */
    public function getValues(\xPDOObject $object, array $extraFields = []): array
    {
        $array = $object->toArray();

        // Include any extra fields
        $array = array_merge($array, $extraFields);

        $values = [];
        foreach ($array as $field => $value) {
            $values[$field] = $value;

            // Check if this field should be parsed by a dedicated field type
            if (array_key_exists($field, $this->fieldClassMap)) {
                $fieldObj = new $this->fieldClassMap[$field]($value, $field);
                $values[$field] = $fieldObj->getValue();

                // Some field types may output multiple values (such as the Properties field type)
                // In this case merge the new values and unset the original
                if (is_array($values[$field])) {
                    $values = array_merge($values, $values[$field]);
                    unset($values[$field]);
                }
            }
            else {
                // Set default field class as Text
                $fieldObj = new \modmore\VersionX\Fields\Text($value, $field);
                $values[$field] = $fieldObj->getValue();
            }
        }

        return $values;
    }

    /**
     * Detect a Field of type Properties and handle saving to the object
     * @param \vxDeltaField $field
     * @param \xPDOObject $object
     * @return void
     */
    protected function savePropertiesFields(\vxDeltaField $field, \xPDOObject $object)
    {
        // Collate Properties fields
        $name = $field->get('field');
        if (strpos($name, '.') !== false) {
            $propField = explode('.', $name)[0];
            if (
                array_key_exists($propField, $this->fieldClassMap)
                && $this->fieldClassMap[$propField] === Properties::class
            ) {
                // Take current properties field value and insert the "before" version at matching array keys.
                $data = $object->get($propField);
                Properties::revertPropertyValue($field, $data, 'before');
                $object->set($propField, $data);
                $object->save();
            }
        }
    }

}