<?php

namespace HolidayLink\Api;

use HolidayLink\Auth\Credentials;
use HolidayLink\Transport\XmlCall;

/**
 * Class Availabilities
 * @package HolidayLink\Api
 */
class Availabilities extends Model {

  /**
   * Number of returned
   * @var integer
   */
  private $count = 0;

  /**
   * Returns the count
   * @return int
   */
  public function getCount () {
    return $this->count;
  }

  /**
   * Create availabilities from XML
   *
   * @param  \SimpleXMLElement $sxe the API response
   *
   * @return $this
   */
  public function fromXML (\SimpleXMLElement $sxe) {
    $availabilities = array();
    $this->count = 0;

    foreach ($sxe->children() as $availability) {
      $en = new Availability();
      $en->fromXml($availability);
      $availabilities[] = $en;
      ++$this->count;
    }
    $this->setData($availabilities);

    return $this;
  }

  /**
   * Retrieve all availabilities matching the $params filter
   *
   * @param  array $params filter parameters
   * @param  Credentials $credentials API credentials
   *
   * @return $this
   */
  public static function allFromXML (array $params = null, Credentials $credentials = null) {
    if (empty($params)) {
      $params = array();
    }
    if (!empty($credentials)) {
      self::setCredentials($credentials);
    }
    $allowedParams = array(
      'expand' => 1,
    );

    $wrongParams = array_diff_key($params, $allowedParams);
    if (!empty($wrongParams)) {
      throw new \InvalidArgumentException('Invalid $params filter: ' . implode(', ', array_keys($wrongParams)));
    }

    $call = new XmlCall($credentials);
    $sxe = $call->execute('availabilities', array_intersect_key($params, $allowedParams));

    $ret = new self();
    $ret->fromXML($sxe);

    return $ret;
  }
}
