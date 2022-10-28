<?php

namespace Atriontechsd\SimpleTable\App;

class Delete extends CommonColumn
{

    //declare name, label, lenght, sortable
    public String $name;
    public String $label;
    public String $type = 'delete';
    public String $alias;
    public bool $searchable = false;
    public String $table;
    public bool $sortable=false;
    public bool $ellipsis = false;
    public bool $isColumn = false;
    public $cellClass='text-center';


    //declare for delete

    public String $key_name='id';
    public String $title="Deleting data";
    public String $message="Are you sure you want to delete this data?";
    public String $confirm_text="Yes, delete it!";
    public String $cancel_text="Cancel";

  
    public static function name($name)
    {
        $delete = new static;
        $delete->name = $name;
        $delete->label = 'Delete';
        $delete->alias = $name;
        $delete->table="";
        return $delete;
    }
    public  function label($label)
    {
        $this->label = $label;
        return $this;
    }
 
    
    function keyName($key_name){
        $this->key_name=$key_name;
        return $this;
    }
    function title($title){
        $this->title=$title;
        return $this;
    }
    function message($message){
        $this->message=$message;
        return $this;
    }
    function confirmText($confirm_text){
        $this->confirm_text=$confirm_text;
        return $this;
    }
    function cancelText($cancel_text){
        $this->cancel_text=$cancel_text;
        return $this;
    }
    function table($table){
        $this->table=$table;
        return $this;
    }

   
}
