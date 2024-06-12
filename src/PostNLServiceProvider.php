<?php

namespace DenizTezcan\PostNL;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class PostNLServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/postnl.php' => config_path('postnl.php'),
        ]);
    }

    public function register()
    {
        $this->app->bind('postnl', function () {
            return new PostNL();
        });
    }

    public function provides()
    {
        return ['postnl'];
    }
}
