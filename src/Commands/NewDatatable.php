<?php

namespace Atriontechsd\SimpleTable\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Atriontechsd\SimpleTable\Commands\Tablecontent;

class NewDatatable extends Command
{
    public $basePath;
    protected $signature = 'new-datatable {name}';

   
    protected $description = 'Create new component datatable';

   
    public function __construct()
    {
        $this->basePath="app/http/Livewire";
        parent::__construct();
    }
  
     
    public function handle(){
        $path=$this->argument('name');
        $subdir=$this->getSubdir($path);
        $filename=ucfirst($this->getFilename($path)).'Table';
        $filePath=$this->basePath."/".$subdir.$filename.".php";
        $content=$this->getContent($subdir);
        //explode subdir and create dir if not exists
        $this->createDir($subdir);
        
        if(!File::exists($filePath)){
            File::put($filePath, $content);
            $this->info("Component created with name: ".$filename." and path: ".$filePath);
            
        }else{
            $this->error("Component already exists");
        }
    }
    
    public function getSubdir($path){
        $subdir="";
        if(strpos($path, '/')){
            //subdir is string before last slash
            $subdir=substr($path, 0, strrpos($path, '/')+1);
        }
        return $subdir;
    }

    public function getFileName($path){
        $filename="";
        if(strpos($path, '/')){
            //filename is string after last slash
            $filename=substr($path, strrpos($path, '/')+1);
        }
        return $filename?$filename : $path;
    }
    
    public function getContent($subdir){
        $subdir=substr($subdir, 0, -1);
       $contentClass= new Tablecontent( ucfirst($this->getFileName($this->argument('name'))), $subdir);
       $content=$contentClass->getContent();
       return $content;
    }
    public function createDir($subdir){
        if($subdir){
            $subdir=explode('/', $subdir);
            $path=$this->basePath;
            foreach ($subdir as $dir){
                $path.="/".$dir;
                if(!File::exists($path)){
                    File::makeDirectory($path);
                }
            }
        }
    }
}
