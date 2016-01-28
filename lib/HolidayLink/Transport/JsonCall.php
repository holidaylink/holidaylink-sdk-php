<?php

namespace HolidayLink\Transport;

/**
 * Class JsonCall
 * @package HolidayLink\Transport
 */
class JsonCall extends ApiCall {

  /**
   * Constant ACCEPT
   */
  const ACCEPT = 'application/json';

  /**
   * Constant CONTENT_TYPE
   */
  const CONTENT_TYPE = 'application/json';

  /**
   * Prepare header for request
   *
   * @param $data
   *
   * @return array
   */
  protected function prepareHeaders ($data) {
    return [
      'headers' => [
        'Accept' => self::ACCEPT,
        'Content-Type' => self::CONTENT_TYPE,
      ],
      'data' => [
        'json' => $data
      ],
    ];
  }

  /**
   * Returns the decoded JSON response
   *
   * @param $response
   *
   * @return mixed
   */
  protected function parseResponse ($response) {
    // returns decoded json as array
    return $response->json();
  }

}
