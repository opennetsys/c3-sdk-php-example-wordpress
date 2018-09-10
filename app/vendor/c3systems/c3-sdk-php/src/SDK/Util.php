<?php

namespace SDK;

require_once(__DIR__.'/../../vendor/autoload.php');
use Brick\Math\BigInteger;

class Util {
  public static function BN($string, $format='') {
    if ($string == '') {
      $string = '0';
    }

    if ($format == 'hex') {
      return BigInteger::parse($string, 16);
    }

    return BigInteger::of($string);
  }

  public static function string2ByteArray($string) {
    return unpack('C*', $string);
  }

  public static function byteArray2String($byteArray) {
    if (!is_array($byteArray)) {
      return '';
    }

    $chars = array_map('chr', $byteArray);
    if (count($chars) == 0) {
      return '';
    }

    return join($chars);
  }

  public static function byteArray2Hex($byteArray) {
    $chars = array_map("chr", $byteArray);
    $bin = join($chars);
    return bin2hex($bin);
  }

  public static function hex2ByteArray($hexString) {
    $string = hex2bin($hexString);
    return unpack('C*', $string);
  }

  public static function string2Hex($string) {
    return bin2hex($string);
  }

  public static function hex2String($hexString) {
    return hex2bin($hexString);
  }
}


?>
