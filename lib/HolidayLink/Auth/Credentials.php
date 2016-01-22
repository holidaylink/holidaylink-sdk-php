<?php

namespace HolidayLink\Auth;

/**
 * HolidayLink API credentials
 */
class Credentials {

  /**
   * Client access token
   *
   * @var string
   */
  private $accessToken;

  /**
   * Credentials constructor.
   *
   * @param $accessToken
   */
  public function __construct ($accessToken) {
    $this->accessToken = $accessToken;
  }

  /**
   * Returns the access token
   *
   * @return string Client API access token
   */
  public function getAccessToken () {
    return $this->accessToken;
  }

  /**
   * Returns the credentials as array
   *
   * @return array
   */
  public function getArray () {
    return [
      'access-token' => $this->getAccessToken(),
    ];
  }

}
