<?php

namespace App\Providers;

use App\Contracts\PropertyFetchContract;
use App\Models\Property;
use App\Observers\PropertyObserver;
use App\Services\PropertyFetchService;
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
        $this->app->bind(PropertyFetchContract::class, PropertyFetchService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
