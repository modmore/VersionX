<?php

namespace modmore\VersionX\Fields;

use modmore\VersionX\DeltaManager;

abstract class Field
{
    /** @var mixed $value */
    protected $value;
    protected string $fieldName = '';
    protected array $options = [];
    protected string $tpl = '';

    function __construct($value, $name = '', $options = [])
    {
        if (!$this->value) {
            $this->value = $value;
        }

        $this->fieldName = $name;
        $this->options = $options;
        $this->parse();
    }

    /**
     * Runs when the Field is created
     * Override in derivatives if the value needs to be manipulated
     * @return void
     */
    protected function parse()
    {}

    /**
     * @return mixed
     */
    public function getValue($options = [])
    {
        return $this->value;
    }

    public function getName()
    {
        return $this->fieldName;
    }

    /**
     * @return string
     */
    public function getTpl(): string
    {
        return $this->tpl;
    }

    public function render($prevValue, $newValue, $options = []): string
    {
        return DeltaManager::calculateDiff($prevValue, $newValue);
    }
}