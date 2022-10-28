<?php

namespace Atriontechsd\SimpleTable\App;

use Closure;
use Illuminate\Support\Facades\Artisan;
use Nette\Utils\Callback;

class Column extends CommonColumn
{
    //declare name, label, lenght, sortable
  
    
   
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
