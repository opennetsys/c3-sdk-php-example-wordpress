# c3-sdk-php

> The [C3](https://github.com/c3systems/c3-go) SDK for PHP

This SDK can be used for WordPress.

## Install

```bash
composer require c3systems/c3-sdk-php
```

## Usage

Here's a hello world example

```php
require_once(__DIR__.'/../vendor/autoload.php');
use SDK\Client;
use SDK\Util;

class App {
  public $client;

  function __construct() {
    $this->client = new Client;
  }

  function setItem($key, $value) {
    $this->client->state()->set(Util::string2ByteArray($key), Util::string2ByteArray($value));
  }

  function getItem($key) {
    $result = $this->client->state()->get(Util::string2ByteArray($key));
    return Util::byteArray2String($result['value']);
  }
}

$app = new App;
$app->client->registerMethod('setItem', ['string', 'string'], array($app, 'setItem'));
$app->client->registerMethod('getItem', ['string'], array($app, 'getItem'));
$app->client->serve();
```

## Test

```bash
make test
```

## License

[GNU AGPL 3.0](LICENSE)
