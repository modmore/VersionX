<?php

namespace modmore\VersionX\Types;

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
     * @var string $nameField
     * The "human-readable" field used to identify the object.
     */
    protected string $nameField = '';

    /**
     * @var array $tabJavaScript
     * An array of file names that should be included when loading a VersionX tab on an object
     */
    protected array $tabJavaScript = [];

    /**
     * @var array $excludedFields
     * List fields that should not be versioned. A common example might be "editedon" since that changes every save.
     */
    protected array $excludedFields = [];

    /**
     * @var array $fieldOrder
     * List any fields here that should come first in the diff. Those not listed will still be included in the
     * order they're loaded.
     */
    protected array $fieldOrder = [];

    function __construct(\modX $modx, VersionX $versionX)
    {
        $this->modx = $modx;
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
     * Runs before a delta is created
     * @param string $time - Delta create time
     * @param \xPDOObject $object - The object to be versioned
     * @return bool
     */
    public function beforeDeltaCreate(string $time, \xPDOObject $object): bool
    {
        return true;
    }

    /**
     * Add additional \vxDeltaField objects to the array
     * @param \vxDeltaField[] $fields
     * @param \xPDOObject $object
     * @return \vxDeltaField[]
     */
    public function includePrevFieldsOnCreate(array $fields, \xPDOObject $object): array
    {
        return $fields;
    }

    /**
     * Add additional \vxDeltaField objects to the array
     * @param \vxDeltaField[] $fields
     * @param \xPDOObject $object
     * @return \vxDeltaField[]
     */
    public function includeNewFieldsOnCreate(array $fields, \xPDOObject $object): array
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
}