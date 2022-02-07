<?php

namespace App\Providers;

use App\Interfaces\UrlRepositoryInterface;
use App\Repositories\UrlRepository;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class CheckerProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UrlRepositoryInterface::class, function (Application $app) {

            return $app->make(UrlRepository::class);

        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
