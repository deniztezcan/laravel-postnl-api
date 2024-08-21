<?php

namespace NoPulp\Modules\PostNL\Entities;

use NoPulp\Modules\PostNL\Http\Client;

class Entity
{
    protected $client = null;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }
}
