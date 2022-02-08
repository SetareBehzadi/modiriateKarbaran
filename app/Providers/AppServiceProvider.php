<?php

namespace App\Providers;

use App\Services\Storage\Contracts\StorageInterface;
use App\Services\Storage\SessionStorage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(StorageInterface::class, function ($app){
            return new SessionStorage('cart');
        });
    }
}
