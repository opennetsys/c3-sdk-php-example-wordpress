<?php

require_once(__DIR__.'/../vendor/autoload.php');
use SDK\Hexutil;
use SDK\Util;

assert(Hexutil::encodeString('hello') == '0x68656c6c6f');
assert(Hexutil::encodeString('123') == '0x313233');
assert(Hexutil::decodeString('0x1234') == Util::hex2ByteArray('1234'));
assert(Hexutil::decodeString('0x68656c6c6f') == unpack('C*', 'hello'));
assert(Hexutil::encodeToString(Util::string2ByteArray('hello')), '0x68656c6c6f');
assert(Hexutil::encodeBytes(Util::string2ByteArray('hello')), Util::hex2ByteArray('68656c6c6f'));
assert(Hexutil::decodeBytes(Util::string2ByteArray('68656c6c6f')), Util::string2ByteArray('hello'));

assert(Hexutil::encodeBigInt(Util::BN(123)) == '0x7b');
assert(Hexutil::encodeBigInt(Util::BN(53452345)) == '0x32f9e39');
assert(Hexutil::encodeBigInt(Util::BN('7237005577332262213973186563042994240829374041602535253248099000494570602496')) == '0x10000000000000000000000000000000000000000000002a646e18c953780000');
assert(Hexutil::decodeBigInt('0x7B')->toBase(16) == Util::BN(123)->toBase(16));

assert(Hexutil::stripPrefix('0x123') == '123');
assert(Hexutil::stripPrefix('123') == '123');
assert(Hexutil::stripPrefix('0x') == '');
assert(Hexutil::addPrefix('123') == '0x123');
assert(Hexutil::addPrefix('0x123') == '0x123');

?>
