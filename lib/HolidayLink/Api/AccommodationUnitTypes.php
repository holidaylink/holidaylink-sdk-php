<?php

namespace HolidayLink\Api;

use HolidayLink\Auth\Credentials;
use HolidayLink\Transport\XmlCall;

/**
 * Class AccommodationUnitTypes
 * @package HolidayLink\Api
 */
class AccommodationUnitTypes extends Model {

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
   * Create accommodation unit types from XML
   *
   * @param  \SimpleXMLElement $sxe the API response
   *
   * @return self
   */
  public function fromXML (\SimpleXMLElement $sxe) {
    $accommodationUnitTypes = array();
    $this->count = 0;

    foreach ($sxe->children() as $accommodationUnitType) {
      $cat = new AccommodationUnitType();
      $cat->fromXml($accommodationUnitType);
      $accommodationUnitTypes[] = $cat;
      ++$this->count;
    }
    $this->setData($accommodationUnitTypes);

    return $this;
  }

  /**
   * Retrieve all accommodation unit types matching the $params filter
   *
   * @param  array $params
   * @param  Credentials $credentials API credentials
   *
   * @return self
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
    $sxe = $call->execute('accommodation-unit-types', 'GET', array_intersect_key($params, $allowedParams));

    $ret = new self();
    $ret->fromXML($sxe);

    return $ret;
  }

}
