<?php

require_once(__DIR__.'/vendor/autoload.php');
use SDK\Client;
use SDK\Util;

class App {
  public $client;

  function __construct() {
    $this->client = new Client;
  }

  function createPost($title, $content) {
    $curl = curl_init();

    $payload->title = $title;
    $payload->content= $content;
    $payload->status = 'publish';
    $jsonstr = json_encode($payload);

    curl_setopt_array($curl, array(
      CURLOPT_PORT => "8080",
      CURLOPT_URL => "http://localhost:8080/wp-json/wp/v2/posts",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => $jsonstr,
      CURLOPT_HTTPHEADER => array(
        "authorization: Basic ". base64_encode("admin:password"),
        "cache-control: no-cache",
        "content-type: application/json"
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
