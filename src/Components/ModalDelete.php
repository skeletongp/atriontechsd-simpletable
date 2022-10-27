<?
namespace Atriontechsd\SimpleTable\Components;

use Livewire\Component;

class ModalDelete extends Component
{
    public $key_name='id';
    public $key_value;
    public $table_name;
    public $title;
    public $message;
    public $confirm_text;
    public $params = [];

    public function render()
    {
        return view('simpletable::modal-delete');
    }
}