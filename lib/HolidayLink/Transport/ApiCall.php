<?php

namespace HolidayLink\Transport;

use HolidayLink\Auth\Credentials,
  HolidayLink\Constants,
  Exception,
  GuzzleHttp,
  GuzzleHttp\Exception\RequestException;


/**
 * Class ApiCall
 *
 * @package HolidayLink\Transport
 */
abstract class ApiCall {

  /**
   * API credentials
   *
   * @var Credentials
   */
  private $apiCredentials;

  /**
   * API endpoint URL
   *
   * @var null|string
   */
  private $endpointUrl;

  /**
   * ApiCall constructor - Constructs new XML API call using the provided credentials
   *
   * @param Credentials $apiCredentials
   * @param null $endpointUrl API endpoint URL
   */
  public function __construct (Credentials $apiCredentials, $endpointUrl = null) {
    $this->apiCredentials = $apiCredentials;

    if (!empty($endpointUrl)) {
      $this->endpointUrl = $endpointUrl;
    }

    return $this;
  }

  /**
   * Returns the API endpoint URL.
   * If the URL is not set, uses the one
   * from Constants
   *
   * @return null|string API endpoint URL
   */
  public function getEndpointUrl () {
    if (empty($this->endpointUrl)) {
      $this->endpointUrl = Constants::API_LIVE_ENDPOINT;
    }

    return $this->endpointUrl;
  }

  /**
   * Returns URL-encoded query string of API credentials if instance of Credentials
   *
   * @return string
   * @throws Exception
   */
  private function getCredentialsUrlParams () {
    if (!($this->apiCredentials instanceof Credentials)) {
      throw new Exception('API credentials not set.');
    }

    return http_build_query($this->apiCredentials->getArray());
  }

  /**
   * Returns API credentials as array if instance of Credentials
   *
   * @return array
   * @throws Exception
   */
  private function getCredentialsAsArray () {
    if (!($this->apiCredentials instanceof Credentials)) {
      throw new Exception('API credentials not set.');
    }

    return $this->apiCredentials->getArray();
  }

  /**
   * Returns the URL
   *
   * @param  string $url URL to grab
   *
   * @return array
   * @throws Exception
   */
  public function getURL ($path, $params) {
    $credentials = $this->getCredentialsAsArray();
    return $this->getEndpointUrl() . $path . '?' . http_build_query(array_merge($credentials, $params));
  }

  /**
   * Execute API call and return the response
   *
   * @param $path
   * @param array $params
   *
   * @return mixed
   * @throws Exception
   */
  public function execute ($path, $params = []) {
    $url = $this->getURL($path, $params);

    $client = new GuzzleHttp\Client();

    try {
      $response = $client->get($url, [
        'headers' => [
          'Accept' => static::ACCEPT,
        ],
        'verify' => false,
      ]);
    } catch (RequestException $e) {
      echo $e->getRequest() . "\n";

      if ($e->hasResponse()) {
        echo $e->getResponse() . "\n";
      }
    }

    return $this->parseResponse($response);
  }

  /**
   * Returns the parsed response
   */
  abstract protected function parseResponse ($response);
}
