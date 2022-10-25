<?php
namespace Atriontechsd\SimpleTable\Providers;

use Atriontechsd\SimpleTable\Commands\NewDatatable;
use Illuminate\Support\ServiceProvider;

class SimpletableServiceProvider extends ServiceProvider
{
    public function boot()
    {
      //add /src/Commands/NewDatatable command to project's commands
       /*  if ($this->app->runningInConsole()) {
            $this->commands([
                NewDatatable::class,
            ]);
        } */

    }

    public function register()
    {
       
    }
}
