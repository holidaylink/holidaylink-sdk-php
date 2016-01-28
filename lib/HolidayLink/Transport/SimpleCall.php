<?php

namespace HolidayLink\Transport;

/**
 * Class SimpleCall
 * @package HolidayLink\Transport
 */
class SimpleCall extends ApiCall {

  /**
   * Constant ACCEPT
   */
  const ACCEPT = '';

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
      ],
    ];
  }

  /**
   * Returns the XML response as SimpleXMLElement
   *
   * @param $response
   *
   * @return mixed
   */
  protected function parseResponse ($response) {
    return $response;
  }
}
