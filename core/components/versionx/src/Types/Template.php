<?php

namespace modmore\VersionX\Types;

class Template extends Type
{
    protected string $class = 'modTemplate';
    protected string $tabId = 'modx-template-tabs';
    protected string $panelId = 'modx-panel-template';
    protected string $package = 'core';
    protected string $nameField = 'templatename';
    protected array $fieldOrder = [
        'templatename',
        'description',
        'content',
    ];
}