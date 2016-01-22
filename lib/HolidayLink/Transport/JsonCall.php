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
   * Returns the decoded JSON response
   *
   * @param $response - JSON encoded response
   *
   * @return mixed
   * @throws \Exception
   */
  protected function parseResponse ($response) {
    if (($decodedResponse = json_decode($response['content'], true)) === false) {
      throw new \Exception('API error: ' . $response['content']);
    }

    return $decodedResponse;
  }
}
