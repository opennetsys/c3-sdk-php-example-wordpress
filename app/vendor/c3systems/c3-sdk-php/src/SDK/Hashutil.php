<?php

namespace SDK;

require_once(__DIR__.'/../../vendor/autoload.php');
use SDK\Util;
use SDK\Hexutil;

class Hashutil {
  public static function generateHash() {
    $str = substr(base64_encode(sha1(mt_rand())), 0, 16);
    return hash('sha512/256', $str);
  }

  public static function hashByteArray($byteArray) {
    return Util::hex2ByteArray(hash('sha512/256', Util::byteArray2String($byteArray)));
  }

  public static function hashToHexString($byteArray) {
    return Hexutil::addPrefix(hash('sha512/256', Util::byteArray2String($byteArray)));
  }

  public static function isEqual($hexString, $byteArray) {
    return strtolower($hexString) == Hashutil::hashToHexString($byteArray);
  }
}

?>
