<?php

namespace HolidayLink\Api;

use HolidayLink\Auth\Credentials;
use HolidayLink\Transport\JsonCall;
use HolidayLink\Transport\SimpleCall;
use HolidayLink\Transport\XmlCall;

/**
 * Class DiscountValue
 * @package HolidayLink\Api
 */
class DiscountValue extends Model {

  public static $fields = [
    'id',
    'discount',
    'status',
    'amount',
    'accommodationUnit',
    'created_at',
    'updated_at',
  ];

  /**
   * discount_id options:
   *  - use discount id keys from Discounts::allFromXML()
   *
   * status options:
   *  - use constants from charge value statuses
   *
   * amount_value format: 10.10
   *
   * amount_unit options:
   *  - use options from charge amount unit contants
   *
   * accommodation_unit_id options:
   *  - use keys from AccommodationUnits::allFromXML()
   *
   * @var array
   */
  public static $requiredFields = [
    'discount_id',
    'status',
    'amount_value',
    'amount_unit',
    'accommodation_unit_id',
  ];

  /**
   * Discount value statuses
   */
  const STATUS_ACTIVE = 'active';
  const STATUS_DISABLED = 'disabled';

  /************************ Additional options **************************
   *
   * Discount value amount unit
   */
  const AMOUNT_UNIT_PERCENTAGE = 'percentage';
  const AMOUNT_UNIT_ABSOLUTE = 'absolute';

  /**
   * Discount value bed type
   */
  const BED_TYPE_REGULAR = 'regular';
  const BED_TYPE_EXTRA = 'extra';

  /**
   * Retrieve single discount value matching the $code filter
   *
   * @param  string $code
   * @param  array $params
   * @param  Credentials $credentials API credentials
   *
   * @return self  the retrieved discount value
   */
  public static function singleFromXML ($code, array $params = null, Credentials $credentials = null) {
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
    $sxe = $call->execute('discount-values/' . $code, 'GET', array_intersect_key($params, $allowedParams));

    $ret = new self();
    $ret->fromXML($sxe);

    return $ret;
  }

  /**
   * Create single discount value from array of key => value params
   *
   * @param  array $params
   * @param  array $data
   * @param  Credentials $credentials API credentials
   *
   * @return self
   */
  public static function createSingle (array $params = [], array $data= [], Credentials $credentials = null) {
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

    $requiredParams = array_diff(self::$requiredFields, array_keys($data));
    if (!empty($requiredParams)) {
      throw new \InvalidArgumentException('Required params: ' . implode(', ', $requiredParams));
    }

    $call = new JsonCall($credentials);
    $sxe = $call->execute('discount-values', 'POST', array_intersect_key($params, $allowedParams), $data);

    return $sxe;
  }

  /**
   * Update single discount value matching the $code filter and array of key => value params
   *
   * @param  string $code
   * @param  array $params
   * @param  array $data
   * @param  Credentials $credentials API credentials
   *
   * @return self  the updated discount value
   */
  public static function updateSingle ($code, array $params = [], array $data= [], Credentials $credentials = null) {
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

    $call = new JsonCall($credentials);
    $sxe = $call->execute('discount-values/' . $code, 'PUT', array_intersect_key($params, $allowedParams), $data);

    return $sxe;
  }

  /**
   * Delete single discount value matching the $code filter
   *
   * @param  string $code
   * @param  Credentials $credentials API credentials
   *
   * @return mixed
   */
  public static function deleteSingle ($code, Credentials $credentials = null) {

    if (!empty($credentials)) {
      self::setCredentials($credentials);
    }

    $call = new SimpleCall($credentials);
    $response = $call->execute('discount-values/' . $code, 'DELETE');

    return $response;
  }
}
