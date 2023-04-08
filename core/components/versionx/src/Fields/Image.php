<?php

namespace modmore\VersionX\Fields;

use modmore\VersionX\DeltaManager;

class Image extends Field
{
    protected function parse()
    {

    }

    public function render(string $prevValue, string $newValue, array $options = []): string
    {
        $diff = DeltaManager::calculateDiff($prevValue, $newValue);
        // todo: render before and after images into diff (process with media source) - templates/mgr/fields/image.tpl
        return $diff;
    }
}