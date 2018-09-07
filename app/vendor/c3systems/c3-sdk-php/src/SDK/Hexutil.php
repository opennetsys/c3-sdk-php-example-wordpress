<?php

namespace SDK;

require_once(__DIR__.'/../../vendor/autoload.php');
use SDK\Util;

class Hexutil {
  public static function encodeString($string) {
    return strtolower(Hexutil::addPrefix(Util::string2Hex($string)));
  }

  public static function decodeString($hexString) {
    $string = Hexutil::stripPrefix($hexString);
    return Util::hex2ByteArray($string);
  }

  public static function encodeToString ($buf) {
    return strtolower(Hexutil::addPrefix(Util::byteArray2Hex($buf)));
  }

  public static function encodeBytes($src) {
    return Util::hex2ByteArray(Util::byteArray2Hex($src));
  }

  public static function decodeBytes($src) {
    return Util::hex2ByteArray(Util::byteArray2String($src));
  }

  public static function encodeBigInt($bn) {
    return strtolower(Hexutil::addPrefix($bn->toBase(16)));
  }

  public static function decodeBigInt($hexString) {
    return Util::BN(Hexutil::stripPrefix($hexString), 'hex');
  }

  public static function stripPrefix($hexString) {
    return preg_replace("/^0x/", '', $hexString);
  }

  public static function addPrefix($string) {
    return '0x'.Hexutil::stripPrefix($string);
  }
}

?>
