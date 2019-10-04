<?php

namespace DenizTezcan\LaravelPostNLAPI;

use DenizTezcan\LaravelPostNLAPI\Services\Client;

class PostNLAPI
{
	public function generateBarcode(
		$type 	= "3S",
		$serie 	= "000000000-999999999",
		$customer = null
	){
		$client 	= new Client();
		$barcode 	= $client::get("shipment/v1_1/barcode?Type=".$type."&Serie=".$serie, $customer);
		return $barcode['Barcode'];
	}
}