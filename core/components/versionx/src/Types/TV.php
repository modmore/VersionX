<?php

namespace modmore\VersionX\Types;

class TV extends Type
{
    protected string $class = \modTemplateVar::class;
    protected string $tabId = 'modx-tv-tabs';
    protected string $panelId = 'modx-panel-tv';
    protected string $package = 'core';
    protected string $nameField = 'name';
    protected array $fieldOrder = [
        'name',
        'caption',
        'description',
        'type',
    ];
}