<?php

namespace DenizTezcan\PostNL\Facades;

use Illuminate\Support\Facades\Facade;

class PostNL extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'postnl';
    }
}
