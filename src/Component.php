<?php

namespace Atriontechsd\SimpleTable;

class Component
{
    public $name;
    public $properties = [];
    public $type = 'component';

    public static function name($name)
    {
        $component = new static;
        $component->name = $name;
        return $component;
    }

    public function properties($properties)
    {
        $this->properties = $properties;
        return $this;
    }
}
