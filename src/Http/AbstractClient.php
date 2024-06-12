<?php

namespace DenizTezcan\PostNL\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

class AbstractClient
{
    public $client;

    public $demo = false;

    public function __construct()
    {
        $this->client = new Client();
        $this->demo = config('postnl.demo');
    }

    private function getDefaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json; charset=UTF-8',
            'apikey' => config('postnl.api.key'),
        ];
    }

    private function getBaseUrl()
    {
        if ($this->demo) {
            return 'https://api-sandbox.postnl.nl/parcels/shipments/v4';
        } else {
            return 'https://api.postnl.nl/parcels/shipments/v4';
        }
    }

    protected function getApiUrl(string $endpoint): string
    {
        return $this->getBaseUrl().$endpoint;
    }

    public function get(
        string $url,
        array $query = [],
        array $headers = []
    ): Response {
        return $this->client->request('GET', $url, [
            'query' => $query,
            'headers' => array_merge(
                $this->getDefaultHeaders(),
                $headers,
            ),
        ]);
    }

    public function post(
        string $url,
        array $parameters = [],
        array $headers = []
    ): Response {
        return $this->client->request('POST', $url, [
            'body' => json_encode($parameters),
            'headers' => array_merge(
                $this->getDefaultHeaders(),
                $headers,
            ),
        ]);
    }
}
