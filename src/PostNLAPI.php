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
		$client = new Client();
		
	}
}