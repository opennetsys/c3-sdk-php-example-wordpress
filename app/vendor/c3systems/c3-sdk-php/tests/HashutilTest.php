<?php

require_once(__DIR__.'/../vendor/autoload.php');
use SDK\Util;
use SDK\Hashutil;

assert(strlen(Hashutil::generateHash()) == 64);
assert(Hashutil::hashByteArray(Util::string2ByteArray('hello world')) == Util::hex2ByteArray('0ac561fac838104e3f2e4ad107b4bee3e938bf15f2b15f009ccccd61a913f017'));

assert(Hashutil::hashToHexString(Util::string2ByteArray('hello world')) == '0x0ac561fac838104e3f2e4ad107b4bee3e938bf15f2b15f009ccccd61a913f017');
assert(Hashutil::isEqual('0x1234', Util::string2ByteArray('foo')) == false);
assert(Hashutil::isEqual('0x0ac561fac838104e3f2e4ad107b4bee3e938bf15f2b15f009ccccd61a913f017', Util::string2ByteArray('hello world')) == true);

?>
