<?php

namespace HolidayLink\Core;

use GuzzleHttp;
use GuzzleHttp\Exception\RequestException;

/**
 * Class GuzzleHttpConnection
 * @package HolidayLink\Core
 */
class GuzzleHttpConnection {

  /**
   * @var GuzzleHttpConnection
   */
  private $client;

  /**
   * Supported request methods
   *
   * @var array
   */
  private $requestMethods = [
    'GET' => 'get',
    'POST' => 'post',
    'PUT' => 'put',
    'DELETE' => 'delete',
  ];

  /**
   * GuzzleHttpConnection constructor.
   */
  public function __construct() {
    $this->client = new GuzzleHttp\Client();
  }

  /**
   * Execute guzzle method
   *
   * @param $url
   * @param $method
   *
   * @return bool
   * @throws \Exception
   */
  public function execute ($url, $method, $headers) {
    if (!array_key_exists($method, $this->requestMethods)) {
      throw new \Exception('Undefined method');
    }

    try {
      $options = array_merge([
          'headers' => $headers['headers'],
          'verify' => false,
        ],
        array_key_exists('data', $headers) ? $headers['data'] : []
      );

      $response = $this->client->request($this->requestMethods[$method], $url, $options);

      if ($response->getStatusCode() != 200)
        throw new \Exception('Invalid respone code - ' . $response->getStatusCode());

      return $response;

    } catch (RequestException $e) {
      echo $e->getMessage() . "\n";

      if ($e->hasResponse()) {
        echo $e->getResponse() . "\n";
      }
      return false;
    }

    return $response;
  }

}
