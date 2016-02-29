<?php

namespace HolidayLink\Api;

use HolidayLink\Auth\Credentials;
use HolidayLink\Transport\JsonCall;
use HolidayLink\Transport\XmlCall;

/**
 * Class Locations
 * @package HolidayLink\Api
 */
class Locations extends Model {

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
   * Create locations from XML
   *
   * @param  \SimpleXMLElement $sxe the API response
   *
   * @return $this
   */
  public function fromXML (\SimpleXMLElement $sxe) {
    $locations = array();
    $this->count = 0;

    foreach ($sxe->children() as $location) {
      $en = new Location();
      $en->fromXml($location);
      $locations[] = $en;
      ++$this->count;
    }
    $this->setData($locations);

    return $this;
  }

  /**
   * Retrieve all locations matching the $params filter
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
      'language' => 1,
      'page' => 1,
    );

    $wrongParams = array_diff_key($params, $allowedParams);
    if (!empty($wrongParams)) {
      throw new \InvalidArgumentException('Invalid $params filter: ' . implode(', ', array_keys($wrongParams)));
    }

    $call = new XmlCall($credentials);
    $sxe = $call->execute('locations', 'GET', array_intersect_key($params, $allowedParams));
    self::setTotalPageCount($call->getTotalPageCount());

    $ret = new self();
    $ret->fromXML($sxe);

    return $ret;
  }

  /**
   * Retrieve all locations matching the $params
   *
   * @param  array $params
   * @param  Credentials $credentials API credentials
   *
   * @return self  the retrieved locations
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
      'parent_id' => 1,
      'population' => 1,
      'map_zoom' => 1,
      'altitude' => 1,
      'created_at' => 1,
      'updated_at' => 1,
      'fields' => 1,
      'country_code' => 1,
      'country_codes' => 1,
      'tel_code' => 1,
      'tel_ambulance' => 1,
      'tel_police' => 1,
      'tel_road_aid' => 1,
      'tel_emergency' => 1,
      'tel_fire' => 1,
      'special' => 1,
      'status' => 1,
      'type' => 1,
      'name' => 1,
      'created_type' => 1,
      'status_for_dropdown' => 1,
      'area_size' => 1,
      'map_lat' => 1,
      'map_lng' => 1
    );

    $wrongParams = array_diff_key($params, $allowedParams);
    if (!empty($wrongParams)) {
      throw new \InvalidArgumentException('Invalid $params filter: ' . implode(', ', array_keys($wrongParams)));
    }

    $call = new XmlCall($credentials);
    $sxe = $call->execute('locations/search', 'GET', array_intersect_key($params, $allowedParams));
    self::setTotalPageCount($call->getTotalPageCount());

    $ret = new self();
    $ret->fromXML($sxe);

    return $ret;
  }

  /**
   * Retrieve all countries
   *
   * @param  Credentials $credentials API credentials
   *
   * @return self  the retrieved countres
   */
  public static function countries (Credentials $credentials = null) {
    if (!empty($credentials)) {
      self::setCredentials($credentials);
    }

    $call = new JsonCall($credentials);
    $sxe = $call->execute('locations/statuses', 'GET', []);
    self::setTotalPageCount($call->getTotalPageCount());

    return $sxe;
  }

  /**
   * Retrieve all cities
   *
   * @param  Credentials $credentials API credentials
   *
   * @return self  the retrieved cities
   */
  public static function cities (Credentials $credentials = null) {
    if (!empty($credentials)) {
      self::setCredentials($credentials);
    }

    $call = new JsonCall($credentials);
    $sxe = $call->execute('locations/cities', 'GET', []);
    self::setTotalPageCount($call->getTotalPageCount());

    return $sxe;
  }

}
