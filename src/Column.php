<?php

namespace Atriontechsd\SimpleTable;

class Column
{

    //declare name, label, lenght, sortable
    public String $name;
    public String $label;
    public int $length = 20;
    public bool $sortable = false;
    public String $type = 'string';
    public String $dateFormat = 'd/m/Y';
    public String $moneyPrefix = '$';
    public String $alias;
    public bool $searchable = false;

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
    public  function length($length)
    {
        $this->length = $length;
        return $this;
    }
    public function sortable($sortable = true)
    {
        $this->sortable = $sortable;
        return $this;
    }
    public function type($type)
    {
        $typeable = ['string', 'date', 'number', 'money'];
        if (in_array($type, $typeable)) {
            $this->type = $type;
        }
        return $this;
    }
    public function format($format)
    {
        switch ($this->type) {
            case 'date':
                $this->dateFormat = $format;
                break;
            case 'money':
                $this->moneyPrefix = $format;
                break;

            default:
                # code...
                break;
        }
        return $this;
    }
    public function alias($alias)
    {
        $this->alias = $alias;
        return $this;
    }
    public function searchable($searchable = true)
    {
        $this->searchable = $searchable;
        return $this;
    }
}
