<?php

namespace HolidayLink\Api;

use HolidayLink\Auth\Credentials;
use HolidayLink\Transport\JsonCall;
use HolidayLink\Transport\XmlCall;

/**
 * Class Accommodations
 * @package HolidayLink\Api
 */
class Accommodations extends Model {

  /**
   * Number of accommodations returned
   * @var integer
   */
  private $count = 0;

  /**
   * Returns the accommodations count
   * @return int
   */
  public function getCount () {
    return $this->count;
  }

  /**
   * Create accommodations from XML
   *
   * @param  \SimpleXMLElement $sxe the API response
   *
   * @return self
   */
  public function fromXML (\SimpleXMLElement $sxe) {
    $accommodations = array();
    $this->count = 0;

    foreach ($sxe->children() as $accommodation) {
      $cat = new Accommodation();
      $cat->fromXml($accommodation);
      $accommodations[] = $cat;
      ++$this->count;
    }
    $this->setData($accommodations);

    return $this;
  }

  /**
   * Retrieve all accommodations matching the $params filter
   *
   * @param  array $params
   * @param  Credentials $credentials API credentials
   *
   * @return self  the retrieved accommodations
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
    $sxe = $call->execute('accommodations', 'GET', array_intersect_key($params, $allowedParams));
    self::setTotalPageCount($call->getTotalPageCount());

    $ret = new self();
    $ret->fromXML($sxe);

    return $ret;
  }

  /**
   * Retrieve all accommodations matching the $params
   *
   * @param  array $params
   * @param  Credentials $credentials API credentials
   *
   * @return self  the retrieved accommodations
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
      'created_at' => 1,
      'updated_at' => 1,
      'location_id' => 1,
      'status' => 1,
      'code' => 1,
      'title' => 1
    );

    $wrongParams = array_diff_key($params, $allowedParams);
    if (!empty($wrongParams)) {
      throw new \InvalidArgumentException('Invalid $params filter: ' . implode(', ', array_keys($wrongParams)));
    }

    $call = new XmlCall($credentials);
    $sxe = $call->execute('accommodations/search', 'GET', array_intersect_key($params, $allowedParams));
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
    $sxe = $call->execute('accommodations/statuses', 'GET', []);
    self::setTotalPageCount($call->getTotalPageCount());

    $ret = new self();
    $ret->fromXML($sxe);

    return $ret;
  }

  /**
   * Retrieve all supplier types
   *
   * @param  Credentials $credentials API credentials
   *
   * @return self  the retrieved supplier types
   */
  public static function supplierTypes (Credentials $credentials = null) {
    if (!empty($credentials)) {
      self::setCredentials($credentials);
    }

    $call = new JsonCall($credentials);
    $sxe = $call->execute('accommodations/supplier-types', 'GET', []);
    self::setTotalPageCount($call->getTotalPageCount());

    $ret = new self();
    $ret->fromXML($sxe);

    return $ret;
  }
}
