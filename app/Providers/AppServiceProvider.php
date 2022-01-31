<?php

namespace App\Providers;

use App\Repositories\UrlRepository;
use App\Repositories\UrlRepositoryInterface;
use Illuminate\Foundation\Application;
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
//        $this->app->bind(UrlRepositoryInterface::class, function (Application $app) {
//
//            return $app->make(UrlRepository::class);
//
//        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
