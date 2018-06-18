<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Car;
use App\Models\Location;
use App\Observers\CarObserver;
use App\Observers\LocationObserver;

class ModelObserversServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        Location::observe(LocationObserver::class);
        Car::observe(CarObserver::class);

    }
}
