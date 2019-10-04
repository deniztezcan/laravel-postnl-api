<?php

namespace DenizTezcan\LaravelPostNLAPI\Facades;

use Illuminate\Support\Facades\Facade;

class PostNLAPI extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'postnlapi';
    }
}
