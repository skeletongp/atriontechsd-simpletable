<?php
namespace Atriontechsd\SimpleTable\Providers;

use Atriontechsd\SimpleTable\Commands\NewDatatable;
use Illuminate\Support\ServiceProvider;

class SimpletableServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../Ciews', 'simpletable');
        if ($this->app->runningInConsole()) {
            $this->commands([
                NewDatatable::class,
            ]);
        }

    }

    public function register()
    {
       
    }
}
