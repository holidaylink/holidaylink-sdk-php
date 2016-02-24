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
   * Total page count
   *
   * @var int
   */
  static protected $totalPageCount = 1;

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
   * @param array $data
   *
   * @return mixed
   */
  public function execute ($path, $method = 'GET', array $params = [], $data = []) {
    $this->url = $this->httpConfig->getURL($path, $params);

    $client = new GuzzleHttpConnection();
    $response = $client->execute($this->url, $method, static::prepareHeaders($data));
    self::$totalPageCount = $response->getHeader('X-Pagination-Page-Count');

    return $this->parseResponse($response);
  }

  /**
   * Get total page count
   * @return int
   */
  public function getTotalPageCount (){
    return self::$totalPageCount;
  }

  /**
   * Returns the parsed response
   */
  abstract protected function parseResponse ($response);

  /**
   * Returns the prepared header
   */
  abstract protected function prepareHeaders ($data);
}
