<?php

namespace App\Providers;

use App\Channel;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        schema::defaultStringLength(191);  

        view()->composer('*' , function ($view) {
            $channel = \Cache::rememberForever('channel' , function () {
                return Channel::all();
            });

            $view->with('channels' , $channel);
        });

        Validator::extend('spamfree' , 'App\Rules\SpamFree@passes');
    }
}
