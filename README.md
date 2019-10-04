Laravel PostNL API package
==============
[![Latest Stable Version](https://poser.pugx.org/deniztezcan/laravel-postnl-api/v/stable)](https://packagist.org/packages/deniztezcan/laravel-postnl-api)
[![Total Downloads](https://poser.pugx.org/deniztezcan/laravel-postnl-api/downloads)](https://packagist.org/packages/deniztezcan/laravel-postnl-api)
[![Latest Unstable Version](https://poser.pugx.org/deniztezcan/laravel-postnl-api/v/unstable)](https://packagist.org/packages/deniztezcan/laravel-postnl-api)
[![License](https://poser.pugx.org/deniztezcan/laravel-postnl-api/license)](https://packagist.org/packages/deniztezcan/laravel-postnl-api)

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
Please set your API: `url`, `key` and Customer `code`, `number` and `location` in the `config/postnlapi.php`

### Usage