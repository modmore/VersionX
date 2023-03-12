<?php

namespace modmore\VersionX\Types;

class Chunk extends Type
{
    protected string $class = \modChunk::class;
    protected string $tabId = 'modx-chunk-tabs';
    protected string $panelId = 'modx-panel-chunk';
    protected string $package = 'core';
    protected string $nameField = 'name';
    protected array $fieldOrder = [
        'name',
        'description',
        'content',
    ];
    protected array $excludedFields = [
        'snippet'
    ];
}