<?php

namespace Infrastructure\Provider;

use Domain\CacheRepository;
use Illuminate\Support\ServiceProvider;
use Infrastructure\Repository\LaravelCacheRepository;

class MicroserviceServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CacheRepository::class, LaravelCacheRepository::class);
    }
}
