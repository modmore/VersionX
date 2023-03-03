<?php

namespace modmore\VersionX\Types;

class Plugin extends Type
{
    protected string $class = 'modPlugin';
    protected string $tabId = 'modx-plugin-tabs';
    protected string $package = 'core';
    protected string $nameField = 'name';
    protected array $tabJavaScript = [
        'grid.deltas.js',
    ];
    protected array $fieldOrder = [
        'name',
        'description',
        'plugincode',
    ];
}