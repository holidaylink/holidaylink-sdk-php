<?php

namespace HolidayLink\Api;

use HolidayLink\Auth\Credentials;
use HolidayLink\Transport\XmlCall;

/**
 * Class DiscountValues
 * @package HolidayLink\Api
 */
class DiscountValues extends Model {

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
   * Create discount values from XML
   *
   * @param  \SimpleXMLElement $sxe the API response
   *
   * @return $this
   */
  public function fromXML (\SimpleXMLElement $sxe) {
    $discountValues = array();
    $this->count = 0;

    foreach ($sxe->children() as $discountValue) {
      $en = new DiscountValue();
      $en->fromXml($discountValue);
      $discountValues[] = $en;
      ++$this->count;
    }
    $this->setData($discountValues);

    return $this;
  }

  /**
   * Retrieve all discount values matching the $params filter
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
    $sxe = $call->execute('discount-values', 'GET', array_intersect_key($params, $allowedParams));
    self::setTotalPageCount($call->getTotalPageCount());

    $ret = new self();
    $ret->fromXML($sxe);

    return $ret;
  }

  /**
   * Retrieve all discount values matching the $params
   *
   * @param  array $params
   * @param  Credentials $credentials API credentials
   *
   * @return self  the retrieved discount values
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
      'discount_id' => 1,
      'accommodation_unit_id' => 1,
      'status' => 1,
      'child_from_age' => 1,
      'child_to_age' => 1,
      'child_plus_adult' => 1,
      'min_number_of_children' => 1,
      'stay_over_number_of_nights' => 1,
      'adult_on_extra_bed' => 1,
      'children_alone_in_room' => 1,
      'pay_number_of_nights' => 1,
      'get_number_of_nights' => 1,
      'single_use' => 1,
      'child_order_number' => 1,
      'applies_to_last_child' => 1,
      'child_on_bed_type' => 1,
      'per_bed' => 1,
    );

    $wrongParams = array_diff_key($params, $allowedParams);
    if (!empty($wrongParams)) {
      throw new \InvalidArgumentException('Invalid $params filter: ' . implode(', ', array_keys($wrongParams)));
    }

    $call = new XmlCall($credentials);
    $sxe = $call->execute('discount-values/search', 'GET', array_intersect_key($params, $allowedParams));
    self::setTotalPageCount($call->getTotalPageCount());

    $ret = new self();
    $ret->fromXML($sxe);

    return $ret;
  }

}
