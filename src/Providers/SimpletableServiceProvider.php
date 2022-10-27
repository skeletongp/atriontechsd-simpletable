<?php
namespace Atriontechsd\SimpleTable\Providers;

use Atriontechsd\SimpleTable\Commands\NewDatatable;
use Atriontechsd\SimpleTable\Commands\NewEdit;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class SimpletableServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../Views', 'simpletable');
        
        Livewire::component('modal-delete', \Atriontechsd\SimpleTable\Components\ModalDelete::class);



        if ($this->app->runningInConsole()) {
            $this->commands([
                NewDatatable::class,
                NewEdit::class
            ]);
        }

    }

    public function register()
    {
       
    }
}
