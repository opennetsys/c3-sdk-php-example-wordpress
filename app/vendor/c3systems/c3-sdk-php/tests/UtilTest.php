<?php

require_once(__DIR__.'/../vendor/autoload.php');
use SDK\Util;

$byteArray = unpack('C*', 'hello');
assert(Util::string2ByteArray('hello') == $byteArray);
assert(Util::byteArray2String($byteArray) == 'hello');

assert(Util::byteArray2Hex($byteArray) == '68656c6c6f');
assert(Util::hex2ByteArray('68656c6c6f') == $byteArray);

assert(Util::string2Hex('hello') == '68656c6c6f');
assert(Util::hex2String('68656c6c6f') == 'hello');

?>
