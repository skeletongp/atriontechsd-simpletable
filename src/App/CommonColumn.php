<?php
namespace Atriontechsd\SimpleTable\App;

class CommonColumn {
    public String $name;
    public String $label;
    public int $length = 20;
    public String $type = 'string';
    public String $dateFormat = 'd/m/Y';
    public String $moneyPrefix = '$';
    public String $alias;
    public bool $sortable = false;
    public bool $searchable = false;
    public bool $ellipsis = false;
    public bool $isColumn = true;
    public bool $hideable=false;
    public bool $hidden=false;
    public $cellClass;

    public static function name($name)
    {
        $column = new static;
        $column->name = $name;
        $column->label = $name;
        $column->alias = $name;
        return $column;
    }

    public  function label($label)
    {
        $this->label = $label;
        return $this;
    }
    public function hideable($hideable = true)
    {
        $this->hideable = $hideable;
        return $this;
    }
    public function hidden($hidden = true)
    {
        $this->hidden = $hidden;
        return $this;
    }
}