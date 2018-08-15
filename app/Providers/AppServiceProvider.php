<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['Dingo\Api\Auth\Auth']->extend('jwt', function ($app) {
            return new \Dingo\Api\Auth\Provider\JWT($app['Tymon\JWTAuth\JWTAuth']);
        });

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        \Event::listen('Illuminate\Database\Events\QueryExecuted', function ($query) {
            // filter oauth ones
                \Log::debug($query->sql . ' - ' . serialize($query->bindings));
        });

    }
}
