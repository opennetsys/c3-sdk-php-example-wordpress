<?php

namespace SDK;

require_once(__DIR__.'/../../vendor/autoload.php');
use SDK\Util;
use Evenement\EventEmitter;

error_reporting(E_ALL);

// Allow the script to hang around waiting for connections
set_time_limit(0);

// Turn on implicit output flushing to we see wha
// we're receiving as it comes in
ob_implicit_flush();

$store = array();
$registeredMethods = array();

class State {
  function set($key, $value) {
    global $store;
    $store[Util::byteArray2Hex($key)] = Util::byteArray2Hex($value);
    $fp = fopen(Kit::statefile, 'w');
    fwrite($fp, json_encode($store));
    fclose($fp);
  }

  function get($key) {
    global $store;
    $v = $store[Util::byteArray2Hex($key)];
    $found = $v != null;
    $value = Util::hex2ByteArray($v);

    return [
      'found' => $found,
      'value' => $value
    ];
  }
}

class Kit {
  const statefile = '/tmp/state.json';
  public $emitter;

  function __construct() {
    $this->emitter = new EventEmitter();
  }

  function setInitialState() {
    if (!file_exists(Kit::statefile)) {
      return;
    }

    global $store;
    $json = file_get_contents(Kit::statefile);
    if ($json != '') {
      $json = json_decode($json, true);

      foreach ($json as $key => $value) {
        $store[$key] = $value;
      }
    }
  }

  function listen() {
    $this->emitter->on('data', function ($data) {
      $this->processPayload($data);
    });
  }

  function processPayload($payload) {
    $args = json_decode($payload, true);
    $this->invoke($args[0], array_slice($args, 1));
  }

  function invoke($methodName, $params) {
    global $registeredMethods;
    $method = $registeredMethods[$methodName];

    $method[0]->{$method[1]}(...$params);
  }
}

class Client {
    public $sdk;

    function __construct() {
      $this->sdk = new Kit;
      $this->sdk->setInitialState();
      $this->sdk->listen();
    }

    function registerMethod($methodName, $types, $fn) {
      global $registeredMethods;
      $registeredMethods[$methodName] = array();
      $registeredMethods[$methodName] = $fn;
    }

    function state() {
      return new State;
    }

    function serve() {
      $host = '0.0.0.0';
      $port = getenv('PORT');

      if ($port == '') {
        $port = 3330;
      }

      $socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
      $result = socket_bind($socket, $host, $port) or die("Could not bind to socket\n");
      $result = socket_listen($socket, 3) or die("Could not set up socket listener\n");
      while(true) {
        $spawn = socket_accept($socket) or die("Could not accept incoming connection\n");
        $input = socket_read($spawn, 1024) or die("Could not read input\n");
        $this->sdk->emitter->emit('data', [$input]);
        socket_close($spawn);
      }

    }
}

?>
