<?php

namespace HolidayLink\Api;

use HolidayLink\Auth\Credentials;
use HolidayLink\Transport\XmlCall;

/**
 * Class Charges
 * @package HolidayLink\Api
 */
class Charges extends Model {

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
   * Create charges from XML
   *
   * @param  \SimpleXMLElement $sxe the API response
   *
   * @return $this
   */
  public function fromXML (\SimpleXMLElement $sxe) {
    $charges = array();
    $this->count = 0;

    foreach ($sxe->children() as $charge) {
      $en = new Charge();
      $en->fromXml($charge);
      $charges[] = $en;
      ++$this->count;
    }
    $this->setData($charges);

    return $this;
  }

  /**
   * Retrieve all charges matching the $params filter
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
    $sxe = $call->execute('charges', 'GET', array_intersect_key($params, $allowedParams));
    self::setTotalPageCount($call->getTotalPageCount());

    $ret = new self();
    $ret->fromXML($sxe);

    return $ret;
  }

  /**
   * Retrieve all charges matching the $params
   *
   * @param  array $params
   * @param  Credentials $credentials API credentials
   *
   * @return self  the retrieved charges
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
      'accommodation_category_id' => 1,
      'title' => 1,
      'display_mandatory' => 1,
      'display_included' => 1,
      'display_optional' => 1,
      'display_per_night' => 1,
      'display_per_week' => 1,
      'display_once' => 1,
      'display_per_person' => 1,
      'display_per_unit' => 1,
    );

    $wrongParams = array_diff_key($params, $allowedParams);
    if (!empty($wrongParams)) {
      throw new \InvalidArgumentException('Invalid $params filter: ' . implode(', ', array_keys($wrongParams)));
    }

    $call = new XmlCall($credentials);
    $sxe = $call->execute('charges/search', 'GET', array_intersect_key($params, $allowedParams));
    self::setTotalPageCount($call->getTotalPageCount());

    $ret = new self();
    $ret->fromXML($sxe);

    return $ret;
  }
}
