<?php

namespace modmore\VersionX\Types;

class Chunk extends Type
{
    protected string $class = 'modChunk';
    protected string $tabId = 'modx-chunk-tabs';
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