<?php

namespace Atriontechsd\SimpleTable\Components;

class Modal

{
     
    public $component;
    public $data=[];
    
    //render view modal with data and component
    public function render(){
        return view('simpletable::modal', [
            'component' => $this->component,
            'data' => $this->data
        ]);
    }
}