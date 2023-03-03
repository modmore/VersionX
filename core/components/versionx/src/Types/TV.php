<?php

namespace modmore\VersionX\Types;

class TV extends Type
{
    protected string $class = 'modTemplateVar';
    protected string $tabId = 'modx-tv-editor-tabs';
    protected string $package = 'core';
    protected string $nameField = 'name';
    protected array $tabJavaScript = [
        'grid.deltas.js',
    ];
    protected array $fieldOrder = [
        'name',
        'caption',
        'description',
        'type',
    ];
}