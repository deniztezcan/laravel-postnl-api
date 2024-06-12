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

    	DenizTezcan\PostNL\PostNLServiceProvider::class,
    ];
```

Add the facade to the facades array:
```php
    'aliases' => [
    	//other things here

    	'PostNL' => DenizTezcan\PostNL\Facades\PostNL::class,
    ];
```

Finally, publish the configuration files:
```
php artisan vendor:publish --provider="DenizTezcan\PostNL\PostNLServiceProvider"
```

### Configuration
Please set your Customer `code`, `number`, `return address` and `apikey` in the `config/postnl.php`

### Usage
To generate a `label` you can use the following call. 
```php

```