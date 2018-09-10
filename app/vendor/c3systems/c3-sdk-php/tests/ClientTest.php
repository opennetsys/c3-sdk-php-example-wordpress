<?php

require_once(__DIR__.'/../vendor/autoload.php');
use SDK\Client;
use SDK\Util;

$client = new Client;
$client->state()->set(Util::string2ByteArray('foo'), Util::string2ByteArray('bar'));

$result = $client->state()->get(Util::string2ByteArray('foo'));

assert($result->found == true);
assert(Util::byteArray2String($result->value) == 'bar');

$result = $client->state()->get(Util::string2ByteArray('qux'));
assert($result->found == false);
assert(Util::byteArray2String($result->value) == '');
