<?php

namespace HolidayLink\Api;

use HolidayLink\Auth\Credentials;
use HolidayLink\Transport\JsonCall;
use HolidayLink\Transport\SimpleCall;
use HolidayLink\Transport\XmlCall;

/**
 * Class ChargeValue
 * @package HolidayLink\Api
 */
class ChargeValue extends Model {

  public static $fields = [
    'id',
    'charge',
    'status',
    'amount',
    'accommodationUnit',
    'calculation_type',
    'calculation_timing',
    'calculation_per_item',
    'created_at',
    'updated_at',
  ];

  /**
   * charge_id options:
   *  - use charge id keys from Charges::allFromXML()
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
    'charge_id',
    'status',
    'amount_value',
    'amount_unit',
    'accommodation_unit_id',
  ];

  /**
   * Charge value statuses
   */
  const STATUS_ACTIVE = 'active';
  const STATUS_DISABLED = 'disabled';

  /************************ Additional options **************************
   *
   * Charge value amount unit
   */
  const AMOUNT_UNIT_PERCENTAGE = 'percentage';
  const AMOUNT_UNIT_ABSOLUTE = 'absolute';

  /**
   * Charge value calculation type
   */
  const CALCULATION_TYPE_INCLUDED = 'included';
  const CALCULATION_TYPE_MANDATORY = 'mandatory';
  const CALCULATION_TYPE_OPTIONAL = 'optional';

  /**
   * Charge value calculation timing
   */
  const CALCULATION_TIMING_PER_NIGHT = 'per_night';
  const CALCULATION_TIMING_PER_WEEK = 'per_week';
  const CALCULATION_TIMING_ONCE = 'once';

  /**
   * Charge value calculation per item
   */
  const CALCULATION_PER_ITEM_UNIT = 'unit';
  const CALCULATION_PER_ITEM_PERSON = 'person';

  /**
   * Retrieve single charge value matching the $code filter
   *
   * @param  string $code
   * @param  array $params
   * @param  Credentials $credentials API credentials
   *
   * @return self  the retrieved charge value
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
    $sxe = $call->execute('charge-values/' . $code, 'GET', array_intersect_key($params, $allowedParams));

    $ret = new self();
    $ret->fromXML($sxe);

    return $ret;
  }

  /**
   * Create single charge value from array of key => value params
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
    $sxe = $call->execute('charge-values', 'POST', array_intersect_key($params, $allowedParams), $data);

    return $sxe;
  }

  /**
   * Update single charge value matching the $code filter and array of key => value params
   *
   * @param  string $code
   * @param  array $params
   * @param  array $data
   * @param  Credentials $credentials API credentials
   *
   * @return self  the updated charge value
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
    $sxe = $call->execute('charge-values/' . $code, 'PUT', array_intersect_key($params, $allowedParams), $data);

    return $sxe;
  }

  /**
   * Delete single charge value matching the $code filter
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
    $response = $call->execute('charge-values/' . $code, 'DELETE');

    return $response;
  }
}
