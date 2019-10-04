<?php

namespace DenizTezcan\LaravelPostNLAPI;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class PostNLAPIServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/postnlapi.php' => config_path('postnlapi.php'),
        ]);
    }

    public function register()
    {
        $this->app->bind('postnlapi', function () {
            return new PostNLAPI();
        });
    }

    public function provides()
    {
        return ['postnlapi'];
    }
}
