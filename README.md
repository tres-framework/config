# Tres config

This package allows you to easily load your configuration files.


## Installing
It's recommended to install by using Composer:

Using the terminal:
```
composer require tres-framework/config
```

## Examples
```php
$config = new Config();

$config->addFromArray([
    'cookie.lifetime_in_hours' => 48,
    'database' => [
        'mysql.host' => '127.0.0.1',
        'mysql.user' => 'bob',
    ],
    'deeply.nested.array.with.zero' => 0,
    'deeply.nested.array.with.a.null' => null,
    'deeply.nested.array.with.a.false' => false,
]);

$config->addFromFile(__DIR__.'/config/database.php');

echo 'Cookie lifetime: '.$config->get('cookie.lifetime_in_hours');
```

You should check out the [unit tests](tests/ConfigTest.php) for more examples.
