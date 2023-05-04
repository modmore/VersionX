<?php

namespace modmore\VersionX\Types;

class Plugin extends Type
{
    protected string $class = \modPlugin::class;
    protected string $tabId = 'modx-plugin-tabs';
    protected string $panelId = 'modx-panel-plugin';
    protected string $package = 'core';
    protected string $nameField = 'name';
    protected array $fieldOrder = [
        'name',
        'description',
        'content',
    ];
    protected array $excludedFields = [
        'id',
        'plugincode',
    ];
}