<?php
namespace Atriontechsd\SimpleTable;

use Illuminate\Support\Facades\Artisan;

class Edit{

    public String $name;
    public String $label;
    public String $type = 'edit';
    public String $alias;
    public bool $sortable=false;
    public $key='id';
    public $table;
    public $componentName;

    public static function key($key=1){
        $edit = new static;
        $edit->key = $key;
        $edit->name=$key;
        return $edit;
    }
    public function table($table){
        $this->table = $table;
        return $this;
    }
    public function name($name){
        $this->componentName = $name;
        if(!file_exists(resource_path('views/livewire/'.$name.'.blade.php'))){
            Artisan::call('new-edit '.$name);
        }

        return $this;
    }
}