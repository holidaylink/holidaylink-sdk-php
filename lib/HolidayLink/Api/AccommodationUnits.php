<?php

namespace HolidayLink\Api;

use HolidayLink\Auth\Credentials;
use HolidayLink\Transport\JsonCall;
use HolidayLink\Transport\XmlCall;

/**
 * Class AccommodationUnits
 * @package HolidayLink\Api
 */
class AccommodationUnits extends Model {

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
   * Create accommodation units from XML
   *
   * @param  \SimpleXMLElement $sxe the API response
   *
   * @return self
   */
  public function fromXML (\SimpleXMLElement $sxe) {
    $accommodationUnits = array();
    $this->count = 0;

    foreach ($sxe->children() as $accommodationUnit) {
      $cat = new AccommodationUnit();
      $cat->fromXml($accommodationUnit);
      $accommodationUnits[] = $cat;
      ++$this->count;
    }
    $this->setData($accommodationUnits);

    return $this;
  }

  /**
   * Retrieve all accommodation units matching the $params filter
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
      'language' => 1,
      'page' => 1,
    );

    $wrongParams = array_diff_key($params, $allowedParams);
    if (!empty($wrongParams)) {
      throw new \InvalidArgumentException('Invalid $params filter: ' . implode(', ', array_keys($wrongParams)));
    }

    $call = new XmlCall($credentials);
    $sxe = $call->execute('accommodation-units', 'GET', array_intersect_key($params, $allowedParams));
    self::setTotalPageCount($call->getTotalPageCount());

    $ret = new self();
    $ret->fromXML($sxe);

    return $ret;
  }

  /**
   * Retrieve all statuses
   *
   * @param  Credentials $credentials API credentials
   *
   * @return self  the retrieved statuses
   */
  public static function statuses (Credentials $credentials = null) {
    if (!empty($credentials)) {
      self::setCredentials($credentials);
    }

    $call = new JsonCall($credentials);
    $sxe = $call->execute('accommodation-units/statuses', 'GET', []);
    self::setTotalPageCount($call->getTotalPageCount());

    return $sxe;
  }

  /**
   * Retrieve all cooperation modes
   *
   * @param  Credentials $credentials API credentials
   *
   * @return self  the retrieved cooperation modes
   */
  public static function cooperationTypes (Credentials $credentials = null) {
    if (!empty($credentials)) {
      self::setCredentials($credentials);
    }

    $call = new JsonCall($credentials);
    $sxe = $call->execute('accommodation-units/cooperation-modes', 'GET', []);
    self::setTotalPageCount($call->getTotalPageCount());

    return $sxe;
  }

  /**
   * Retrieve all accommodation units matching the $params
   *
   * @param  array $params
   * @param  Credentials $credentials API credentials
   *
   * @return self  the retrieved accommodation units
   */
  public static function search (array $params = null, Credentials $credentials = null) {
    if (empty($params)) {
      $params = array();
    }
    if (!empty($credentials)) {
      self::setCredentials($credentials);
    }

    $allowedParams = array(
      'expand' => 1,
      'language' => 1,
      'page' => 1,
      'id' => 1,
      'accommodation_id' => 1,
      'accommodation_unit_type_id' => 1,
      'creator_id' => 1,
      'updater_id' => 1,
      'created_at' => 1,
      'updated_at' => 1,
      'status' => 1,
      'code' => 1,
      'title' => 1
    );

    $wrongParams = array_diff_key($params, $allowedParams);
    if (!empty($wrongParams)) {
      throw new \InvalidArgumentException('Invalid $params filter: ' . implode(', ', array_keys($wrongParams)));
    }

    $call = new XmlCall($credentials);
    $sxe = $call->execute('accommodation-units/search', 'GET', array_intersect_key($params, $allowedParams));
    self::setTotalPageCount($call->getTotalPageCount());

    $ret = new self();
    $ret->fromXML($sxe);

    return $ret;
  }

}
