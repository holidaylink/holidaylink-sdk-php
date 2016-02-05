<?php

namespace HolidayLink\Api;

use HolidayLink\Auth\Credentials;
use HolidayLink\Transport\JsonCall;
use HolidayLink\Transport\SimpleCall;
use HolidayLink\Transport\XmlCall;

/**
 * Class PricelistSeason
 * @package HolidayLink\Api
 */
class PricelistSeason extends Model {

  public static $fields = [
    'id',
    'accommodation',
    'date_arrival',
    'date_departure',
    'nights_minimal',
    'allowed_arrival_day',
    'created_at',
    'updated_at',
  ];

  /**
   * accommodation_id options:
   *  - use id keys from Accommodations::allFromXML()
   *
   * date_arrival, date_departure date format:
   *  - Y-m-d (2016-01-01)
   *
   * nights_minimal options:
   *  - use integer 0 - 7
   *
   * allowed_arrival_day options:
   *  - use defined constants
   * 
   * @var array
   */
  public static $requiredFields = [
    'accommodation_id',
    'date_arrival',
    'date_departure',
    'nights_minimal',
    'allowed_arrival_day',
  ];

  /************************ Additional options **************************
   *
   * Pricelist season statuses
   */
  const STATUS_ACTIVE = 'active';
  const STATUS_DISABLED = 'disabled';

  /**
   * Pricelist season arrival days
   */
  const ARRIVAL_DAY_ANY_DAY = 'any';
  const ARRIVAL_DAY_MONDAY = 'mon';
  const ARRIVAL_DAY_TUESDAY = 'tue';
  const ARRIVAL_DAY_WEDNESDAY = 'wed';
  const ARRIVAL_DAY_THURSDAY = 'thu';
  const ARRIVAL_DAY_FRIDAY = 'fri';
  const ARRIVAL_DAY_SATURDAY = 'sat';
  const ARRIVAL_DAY_SUNDAY = 'sun';
  const ARRIVAL_DAY_SAT_SUN = 'sat-sun';
  const ARRIVAL_DAY_FRI_SAT_SUN = 'fri-sat-sun';

  /**
   * Retrieve single pricelist season matching the $code filter
   *
   * @param  string $code
   * @param  array $params
   * @param  Credentials $credentials API credentials
   *
   * @return self  the retrieved pricelist season
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
    $sxe = $call->execute('pricelist-seasons/' . $code, 'GET', array_intersect_key($params, $allowedParams));

    $ret = new self();
    $ret->fromXML($sxe);

    return $ret;
  }

  /**
   * Create single pricelist season from array of key => value params
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
    $sxe = $call->execute('pricelist-seasons', 'POST', array_intersect_key($params, $allowedParams), $data);

    return $sxe;
  }

  /**
   * Update single pricelist season matching the $code filter and array of key => value params
   *
   * @param  string $code
   * @param  array $params
   * @param  array $data
   * @param  Credentials $credentials API credentials
   *
   * @return self  the updated pricelist season
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
    $sxe = $call->execute('pricelist-seasons/' . $code, 'PUT', array_intersect_key($params, $allowedParams), $data);

    return $sxe;
  }

  /**
   * Delete single pricelist season matching the $code filter
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
    $response = $call->execute('pricelist-seasons/' . $code, 'DELETE');

    return $response;
  }
}
