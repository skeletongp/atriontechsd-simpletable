<?php

namespace Atriontechsd\SimpleTable;

class Delete
{

    //declare name, label, lenght, sortable
    public String $name;
    public String $label;
    public int $length = 20;
    public bool $sortable = false;
    public String $type = 'delete';
    public String $dateFormat = 'd/m/Y';
    public String $moneyPrefix = '$';
    public String $alias;
    public bool $searchable = false;
    public bool $ellipsis = false;

    public $cellClass;
  
    public static function name($name)
    {
        $column = new static;
        $column->name = $name;
        $column->label = 'Delete';
        $column->alias = $name;
        return $column;
    }
    public  function label($label)
    {

        $this->label = $label;
        return $this;
    }
    

   
}
