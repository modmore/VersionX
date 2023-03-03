<?php

namespace modmore\VersionX\Types;

class Snippet extends Type
{
    protected string $class = 'modSnippet';
    protected string $tabId = 'modx-snippet-tabs';
    protected string $panelId = 'modx-panel-snippet';
    protected string $package = 'core';
    protected string $nameField = 'name';
    protected array $tabJavaScript = [
        'grid.deltas.js',
    ];
    protected array $fieldOrder = [
        'name',
        'description',
        'content',
    ];
    protected array $excludedFields = [
        'snippet'
    ];
}