<?php

namespace LaravelEnso\Notifications;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes / api.php');
        $this->loadMigrationsFrom(__DIR__.'/databa s e/migrations');
    }

    public function register()
    {
        //
    }
}
