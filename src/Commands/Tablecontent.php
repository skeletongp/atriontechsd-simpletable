<?php

namespace Atriontechsd\SimpleTable\Commands;

use Illuminate\Support\Str;

class Tablecontent
{

    public $name;
    public $nameLower;
    public $namePlural;
    public $subdir;

    public function __construct($name, $subdir)
    {
        $this->name = ucfirst($name);
        $this->subdir=$subdir;
        $this->nameLower = strtolower($name);
        $this->namePlural = Str::plural($this->nameLower);
    }
    public function getContent()
    {
        $subdir=$this->subdir?: '';
        if ($subdir) {
            $path=" App\Http\Livewire\\".$subdir;
        } else {
            $path=" App\Http\Livewire";
        }
        
        return "<?php
        namespace {$path};
        
        use Atriontechsd\SimpleTable\App\Column;
        use Atriontechsd\SimpleTable\Components\Table;
        use Atriontechsd\SimpleTable\AppTableInterfaz;
        
        class {$this->name}Table extends Table implements TableInterfaz
        {
            public function setTable(): string
            {
                return '{$this->namePlural}';
            }
            public function columns(): array
            {
                return [
                    Column::name('{$this->namePlural}.id')->label('Id')->sortable()->alias('number')->searchable(false),
                   
                ];
            }
            public function joins(): array
            {
                return [
                    /*'related' => [
                        'foreing_key',
                        'local_key',
                        'alias' => 'some_alias'
                    ]*/
                ];
            }".PHP_EOL.

            'public function edit($key_name, $key_value, $table){
                /*
                Your logic here
                */
            }
            
        }
        ';
    }
}
