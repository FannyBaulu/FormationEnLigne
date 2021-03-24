<?php

namespace App\Providers;

use App\Youtube\YoutubeServices;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

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
        $this->app->singleton('App\Youtube\YoutubeServices',function(){
            return new YoutubeServices(env('YOUTUBE_API_KEY'));
        });
    }
}
