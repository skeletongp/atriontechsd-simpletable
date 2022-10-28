<?php
namespace Atriontechsd\SimpleTable\Components;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ModalDelete extends Component
{
    public $key_name;
    public $key_value;
    public $table_name;
    public $title;
    public $message;
    public $confirm_text;
    public $cancel_text;
    public $params = [];

    public function render()
    {
        return view('simpletable::modal-delete');
    }
    public function deleteData(){

        //query builder check if table has deleted_at column
        $table = DB::table($this->table_name);
        $columns = $table->getConnection()->getSchemaBuilder()->getColumnListing($this->table_name);
        if(in_array('deleted_at', $columns)){
              $table->where($this->key_name, $this->key_value)->update(['deleted_at' => now()]);
        }else{
            DB::table($this->table_name)->where($this->key_name, $this->key_value)->delete();
        }

       
         $this->emit('refreshSimpletable');
    }
}