<?php

namespace HolidayLink\Core;

use HolidayLink\Auth\Credentials;
use HolidayLink\Constants;

/**
 * Class HttpConfig
 * @package HolidayLink\Core
 */
class HttpConfig {

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
   * @throws \Exception
   */
  private function getCredentialsUrlParams () {
    if (!($this->apiCredentials instanceof Credentials)) {
      throw new \Exception('API credentials not set.');
    }

    return http_build_query($this->apiCredentials->getArray());
  }

  /**
   * Returns API credentials as array if instance of Credentials
   *
   * @return array
   * @throws \Exception
   */
  private function getCredentialsAsArray () {
    if (!($this->apiCredentials instanceof Credentials)) {
      throw new \Exception('API credentials not set.');
    }

    return $this->apiCredentials->getArray();
  }

  /**
   * Returns the URL
   *
   * @param $path
   * @param $params
   *
   * @return string
   * @throws \Exception
   */
  public function getURL ($path, $params) {
    $credentials = $this->getCredentialsAsArray();
    return $this->getEndpointUrl() . $path . '?' . http_build_query(array_merge($credentials, $params));
  }

}
