<?php

namespace HolidayLink\Transport;

/**
 * Class XmlCall
 * @package HolidayLink\Transport
 */
class XmlCall extends ApiCall {

  /**
   * Constant ACCEPT
   */
  const ACCEPT = 'application/xml';

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
   * @return \SimpleXMLElement
   */
  protected function parseResponse ($response) {
    return new \SimpleXMLElement($response->getBody()->getContents());
  }
}
