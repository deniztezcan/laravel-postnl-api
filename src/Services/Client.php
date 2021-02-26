<?php

namespace DenizTezcan\LaravelPostNLAPI\Services;

use GuzzleHttp\Client as GuzzleClient;
use Throwable;

class Client
{
    protected static $client;

    public function __construct()
    {
        self::initGuzzleClient();
    }

    private static function initGuzzleClient()
    {
        self::$client = new GuzzleClient();
    }

    private static function prepareUrl($url, $customer)
    {
        $fullUrl = config('postnlapi.api.url');
        $fullUrl .= $url;
        $fullUrl .= '&CustomerCode='.$customer->getCustomerCode().'&CustomerNumber='.$customer->getCustomerNumber();

        return $fullUrl;
    }

    private static function handleResponse($data)
    {
        try {
            return json_decode($data, true);
        } catch (Throwable $e) {
            return report($e);
        }
    }

    public static function get($url, $customer)
    {
        $fullUrl = self::prepareUrl($url, $customer);

        $response = self::$client->request('GET', $fullUrl, [
            'headers' => [
                'Content-Type'        => 'application/json; charset=UTF-8',
                'apikey'              => config('postnlapi.api.key'),
            ],
        ]);

        if ($response->getStatusCode() == 200) {
            self::initGuzzleClient();

            return self::handleResponse($response->getBody());
        } else {
            throw new Throwable('PostNL not reporting 200 status', 1);
        }
    }

    public static function post($url, $data, $customer)
    {
        $fullUrl = config('postnlapi.api.url').$url;

        $response = self::$client->request('POST', $fullUrl, [
            'headers' => [
                'Content-Type'        => 'application/json; charset=UTF-8',
                'apikey'              => config('postnlapi.api.key'),
            ],
            'json' => $data,
        ]);

        if ($response->getStatusCode() == 200) {
            self::initGuzzleClient();

            return self::handleResponse($response->getBody());
        } else {
            throw new Throwable('PostNL not reporting 200 status', 1);
        }
    }
}
