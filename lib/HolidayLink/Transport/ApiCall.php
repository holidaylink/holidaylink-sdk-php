<?php

namespace HolidayLink\Transport;

use HolidayLink\Auth\Credentials;
use HolidayLink\Core\GuzzleHttpConnection;
use HolidayLink\Core\HttpConfig;

/**
 * Class ApiCall
 *
 * @package HolidayLink\Transport
 */
abstract class ApiCall {

  /**
   * @var HttpConfig
   */
  private $httpConfig;

  /**
   * @var $url
   */
  private $url;

  /**
   * ApiCall constructor
   *
   * @param Credentials $apiCredentials
   * @param null $endpointUrl API endpoint URL
   */
  public function __construct (Credentials $apiCredentials, $endpointUrl = null) {
    $this->httpConfig = new HttpConfig($apiCredentials, $endpointUrl);
    return $this;
  }

  /**
   * Execute API call and return the response
   *
   * @param $path
   * @param string $method
   * @param array $params
   *
   * @return mixed
   */
  public function execute ($path, $method = 'GET', $params = []) {
    $this->url = $this->httpConfig->getURL($path, $params);

    $headers = [
      'Accept' => static::ACCEPT,
    ];

    $client = new GuzzleHttpConnection();
    $response = $client->execute($this->url, $method, $headers);

    return $this->parseResponse($response);
  }

  /**
   * Returns the parsed response
   */
  abstract protected function parseResponse ($response);
}
