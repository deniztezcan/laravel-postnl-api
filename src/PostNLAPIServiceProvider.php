<?php

namespace DenizTezcan\LaravelPostNLAPI;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class PostNLAPIServiceProvider extends BaseServiceProvider
{
	public function boot()
    {

    }

    public function register()
    {
    	$this->mergeConfigFrom(__DIR__.'/../config/postnlapi.php', 'postnlapi');
    }
	
	public function provides()
	{
		return ['postnlapi'];
	}

}