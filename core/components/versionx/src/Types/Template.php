<?php

namespace modmore\VersionX\Types;

class Template extends Type
{
    protected string $class = 'modTemplate';
    protected string $tabId = 'modx-template-tabs';
    protected string $package = 'core';
    protected array $tabJavaScript = [
        'common/grid.versions.js',
    ];

    public function getPackage(): string
    {
        return $this->package;
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function getTabId(): string
    {
        return $this->tabId;
    }

    public function getTabJavascript(): array
    {
        return $this->tabJavaScript;
    }

}