<?php

namespace modmore\VersionX\Types;

class Resource extends Type
{
    protected string $class = 'modResource';
    protected string $tabId = 'modx-resource-tabs';
    protected string $package = 'core';
    protected string $nameField = 'pagetitle';
    protected array $tabJavaScript = [
        'common/grid.versions.js',
    ];
    protected array $excludedFields = [
        'createdon',
        'createdby',
        'editedon',
        'editedby',
    ];
    protected array $fieldOrder = [
        'pagetitle',
        'longtitle',
        'description',
        'introtext',
        'content',
        'alias',
    ];

}