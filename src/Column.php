<?php

namespace Atriontechsd\SimpleTable;

use Closure;
use Illuminate\Support\Facades\Artisan;
use Nette\Utils\Callback;

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
    public bool $ellipsis = false;

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
        $typeable = ['string', 'date', 'number', 'money', 'modal'];
        if (in_array($type, $typeable)) {
            $this->type = $type;
        }

        return $this;
    }
    //function modal to set component and data as closure that return array

    public function modal(
        string $component,
        string $column
    ) {
        $this->type = 'modal';
        $this->alias = $column;
        $makeModal = new MakeModal();
        $this->component = 
        $makeModal->createModal($component);
        return $this;
    }

    public function cellClass($cellClass)
    {
        $this->cellClass = $cellClass;
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
    public function ellipsis($ellipsis = true)
    {
        $this->ellipsis = $ellipsis;
        return $this;
    }
}
