<?php

namespace DenizTezcan\LaravelPostNLAPI\Services;

use GuzzleHttp\Client as GuzzleClient;
use Exception;

class Client
{
		
	protected static $client;

	public static function construct()
	{
		self::$client = new GuzzleClient();
	}

	private static function prepareUrl($url, $customer)
	{
		$fullUrl = config('postnlapi.api.url');
		$fullUrl.= $url;
		if (null === $customer) {
			$fullUrl.= "&CustomerCode=".config('postnlapi.customer.code')."&CustomerNumber=".config('postnlapi.customer.number');
		} else {
			$fullUrl.= "&CustomerCode=".$customer['code']."&CustomerNumber=".$customer['number'];
		}
	}

	public static function get($url = "", $customer = null)
	{	
		$fullUrl = self::prepareUrl($url, $customer);

		try {
			$response = self::$client->request('GET', $fullUrl);	

			if ($response->getStatusCode() != 200) {
				return $response->getBody();
			} else {
				throw new Exception("PostNL not reporting 200 status", 1);
			}
		} catch (Exception $e) {
			report($e);
			return false;
		}
	}

	public static function post($url = "", $data = [], $customer = null)
	{
		$fullUrl = self::prepareUrl($url, $customer);

		try {
			$response = self::$client->request('POST', $fullUrl, [
				'form_params' => $data
			]);	

			if ($response->getStatusCode() != 200) {
				return $response->getBody();
			} else {
				throw new Exception("PostNL not reporting 200 status", 1);
			}
		} catch (Exception $e) {
			report($e);
			return false;
		}
	}

}