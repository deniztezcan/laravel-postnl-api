Laravel PostNL API package
==============

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