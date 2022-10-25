<?php 
namespace Atriontechsd\SimpleTable\Commands;
use Illuminate\Support\Str;
class Tablecontent{

    public $name;
    public $nameLower;
    public $namePlural;

    public function __construct($name)
    {
        $this->name = ucfirst($name);
        $this->nameLower = strtolower($name);
        $this->namePlural = Str::plural($this->nameLower);
    }
    public function getContent(){
        return "<?php
        namespace App\Http\Livewire;
        
        use Atriontechsd\SimpleTable\Column;
        use Atriontechsd\SimpleTable\Table;
        use Atriontechsd\SimpleTable\TableInterfaz;
        
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
            }
            
        }
        ";
    }
}