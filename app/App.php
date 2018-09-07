<?php

require_once(__DIR__.'/vendor/autoload.php');
use SDK\Client;
use SDK\Util;

class App {
  public $client;

  function __construct() {
    $this->client = new Client;
  }

  function createPost() {
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_PORT => "80",
      CURLOPT_URL => "http://localhost:80/wp-json/wp/v2/posts",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => "{\n\t\"title\": \"test post\",\n\t\"content\": \"hello world!\",\n\t\"status\": \"publish\"\n}",
      CURLOPT_HTTPHEADER => array(
        "authorization: Basic dXNlcjpiaXRuYW1p",
        "cache-control: no-cache",
        "content-type: application/json",
        "postman-token: e96870b3-cd14-594b-d877-48ade3ae229b"
      ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      echo "cURL Error #:" . $err;
    } else {
      echo $response;
    }

  }
}

$app = new App;
$app->client->registerMethod('createPost', [], array($app, 'createPost'));
$app->client->serve();

?>
