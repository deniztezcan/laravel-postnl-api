<?php

namespace DenizTezcan\PostNL\Http;

use GuzzleHttp\Psr7\Response;

class Client extends AbstractClient
{
    public function request(
        string $method,
        string $endpoint,
        array $parameters = [],
        array $headers = []
    ): Response {
        $parameters = array_filter($parameters);

        switch ($method) {
            case 'GET':
                return $this->get($this->getApiURL($endpoint), $parameters, $headers);
                break;
            case 'POST':
                return $this->post($this->getApiURL($endpoint), $parameters, $headers);
                break;
        }
    }
}
