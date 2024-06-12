<?php

namespace DenizTezcan\PostNL;

use DenizTezcan\PostNL\Entities\Parcel;
use DenizTezcan\PostNL\Http\Client;

class PostNL
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function parcel(): Parcel
    {
        return new Parcel($this->client);
    }
}
