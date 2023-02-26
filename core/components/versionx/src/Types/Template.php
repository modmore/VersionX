<?php

namespace modmore\VersionX\Types;

class Template extends Type
{
    protected string $class = 'modTemplate';
    protected string $tabId = 'modx-template-tabs';
    protected string $mgrAction = 'element/template/update';
    protected string $package = 'core';
    protected string $nameField = 'templatename';
    protected array $tabJavaScript = [
        'common/grid.versions.js',
    ];
    protected array $fieldOrder = [
        'templatename',
        'description',
        'content',
    ];
}