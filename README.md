Laravel PostNL API package
==============
[![Latest Stable Version](https://poser.pugx.org/deniztezcan/laravel-postnl-api/v/stable)](https://packagist.org/packages/deniztezcan/laravel-postnl-api)
[![Total Downloads](https://poser.pugx.org/deniztezcan/laravel-postnl-api/downloads)](https://packagist.org/packages/deniztezcan/laravel-postnl-api)
[![Latest Unstable Version](https://poser.pugx.org/deniztezcan/laravel-postnl-api/v/unstable)](https://packagist.org/packages/deniztezcan/laravel-postnl-api)
[![License](https://poser.pugx.org/deniztezcan/laravel-postnl-api/license)](https://packagist.org/packages/deniztezcan/laravel-postnl-api)
[![StyleCI](https://github.styleci.io/repos/212767317/shield?branch=master)](https://github.styleci.io/repos/212767317/shield?branch=master)

Intergrates the PostNL API with Laravel 5 & 6 via a ServiceProvider and Facade.

### Instalation
```
composer require deniztezcan/laravel-postnl-api
```

Add a ServiceProvider to your providers array in `config/app.php`:
```php
    'providers' => [
    	//other things here

    	DenizTezcan\LaravelPostNLAPI\PostNLAPIServiceProvider::class,
    ];
```

Add the facade to the facades array:
```php
    'aliases' => [
    	//other things here

    	'PostNLAPI' => DenizTezcan\LaravelPostNLAPI\Facades\PostNLAPI::class,
    ];
```

Finally, publish the configuration files:
```
php artisan vendor:publish --provider="DenizTezcan\LaravelPostNLAPI\PostNLAPIServiceProvider"
```

### Configuration
Please set your API: `url`, `key` and Customer `code`, `number`, `location`, `email` and `address` in the `config/postnlapi.php`

### Usage
To generate a `barcode` you can use the following call. To find which `type` and `serie` to use please check [PostNL documentation](https://developer.postnl.nl/browse-apis/send-and-track/barcode-webservice/documentation-soap/)
```php
$barcode = PostNLAPI::generateBarcode('3S', '00000000000-99999999999');
```

To generate a `label` you can use the following call. To find which `PrinterType`, `AddressType` and `ProductCodeDelivery` to use please check [PostNL documentation](https://developer.postnl.nl/browse-apis/send-and-track/labelling-webservice/documentation/)
```php
use DenizTezcan\LaravelPostNLAPI\Entities\{Address, Contact};

$label = PostNLAPI::generateLabel(
	$barcode, 
	'GraphicFile|PDF',
	[Address::create([
        'AddressType' 	=> '01',
        'City'        	=> "Testdorp",
        'CompanyName' 	=> "Crusty Crab BV",
        'Countrycode' 	=> "NL",
        'HouseNr'     	=> "1",
        'Street'      	=> "Teststraat",
        'Zipcode'     	=> "1111AA",
        'FirstName'	  	=> "Meneer",
        'Name'	 	  	=> "Krabs"
    ]),
    Address::create([
        'AddressType'   => '09',
        'City'          => "Testdorp",
        'CompanyName'   => "Crusty Crab BV",
        'Countrycode'   => "NL",
        'HouseNr'       => "1",
        'Street'        => "Teststraat",
        'Zipcode'       => "1111AA",
        'FirstName'     => "Meneer",
        'Name'          => "Krabs"
    ])],
    [Contact::create([
    	'ContactType'	=> "01",
    	'Email'			=> 'test@meneer.nl',
    	'SMSNr'			=> '061111111',
    	'TelNr'			=> '061111111'
    ])],
    '01',
    '3085',
    'This is a reference',
    'This is a remark'
);
```
**_Note:_** Watch the Array which needs to be passed in the second and third parameter! Without this it will simply not work!

To get an array of the nearest PostNL locations you can use the following call. You have to pass the `CountryCode` and `PostalCode` as parameters.
```php
$locations = PostNLAPI::nearestLocations('NL', '1111AA');
```