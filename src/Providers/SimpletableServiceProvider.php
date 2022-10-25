<?php
namespace Atriontechsd\SimpleTable\Providers;

use Atriontechsd\SimpleTable\Commands\NewDatatable;
use Atriontechsd\SimpleTable\Commands\NewEdit;
use Illuminate\Support\ServiceProvider;

class SimpletableServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../Views', 'simpletable');
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
