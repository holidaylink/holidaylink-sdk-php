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
   * Returns the XML response as SimpleXMLElement
   *
   * @param $response
   *
   * @return \SimpleXMLElement
   * @throws \Exception
   */
  protected function parseResponse ($response) {
    return $response->xml();
  }
}
