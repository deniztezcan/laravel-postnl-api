<?php

namespace DenizTezcan\PostNL\Entities;

use DenizTezcan\PostNL\Http\Client;

class Entity
{
    protected $client = null;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }
}
