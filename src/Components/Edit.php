<?php

namespace Atriontechsd\SimpleTable\Components;

use Livewire\Component;

class Edit extends Component
{
    public $key_name;
    public $key_value;
    public $table;
    public $componentName;
    
    public function setTable($table){
        $this->table = $table;
    }
    public function setKeyName($key_name){
        $this->key_name = $key_name;
    }
    public function setKeyValue($key_value){
        $this->key_value = $key_value;
    }

    public function render()
    {
        return view('livewire.'.$this->componentName, [
            'key_name' => $this->key_name,
            'key_value' => $this->key_value,
            'table' => $this->table,
        ]);
    }

    public function emitEdit($key_name, $key_value, $table){
        $this->emit('edit', $key_name, $key_value, $table);
    }
}
