<?php

namespace HolidayLink\Api;

use HolidayLink\Auth\Credentials;
use HolidayLink\Transport\JsonCall;
use HolidayLink\Transport\SimpleCall;
use HolidayLink\Transport\XmlCall;

/**
 * Class Pricelist
 * @package HolidayLink\Api
 */
class Pricelist extends Model {

  public static $fields = [
    'id',
    'accommodationUnit',
    'date_arrival',
    'date_departure',
    'nights_minimal',
    'allowed_arrival_day',
    'method',
    'min_persons',
    'max_persons',
    'price',
    'created_at',
    'updated_at',
  ];

  /**
   * accommodation_id options:
   *  - use id keys from Accommodations::allFromXML()
   *
   * date_arrival, date_departure format:
   *  - Y-m-d format (2016-01-01)
   *
   * @var array
   */
  public static $requiredFields = [
    'accommodation_unit_id',
    'date_arrival',
    'date_departure',
  ];

  /************************ Additional options **************************
   *
   * Pricelist statuses
   */
  const STATUS_ACTIVE = 'active';
  const STATUS_DISABLED = 'disabled';

  /**
   * Pricelist methods
   */
  const METHOD_PER_UNIT_PER_DAY = 'per_unit_per_day';
  const METHOD_PER_PERSON_PER_DAY = 'per_person_per_day';
  const METHOD_PER_EXCURSION = 'per_excursion';
  const METHOD_PER_WEEK = 'per_week';

  /**
   * Pricelist scenarios
   */
  const SCENARIO_CREATE = 'create';
  const SCENARIO_WIZARD = 'wizard';
  const SCENARIO_SEASONS = 'seasons';

  /**
   * Pricelist arrival days
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
   * Retrieve single pricelist matching the $code filter
   *
   * @param  string $code
   * @param  array $params
   * @param  Credentials $credentials API credentials
   *
   * @return self  the retrieved pricelist
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
    $sxe = $call->execute('pricelists/' . $code, 'GET', array_intersect_key($params, $allowedParams));

    $ret = new self();
    $ret->fromXML($sxe);

    return $ret;
  }

  /**
   * Create single pricelist from array of key => value params
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
    $sxe = $call->execute('pricelists', 'POST', array_intersect_key($params, $allowedParams), $data);

    return $sxe;
  }

  /**
   * Update single pricelist matching the $code filter and array of key => value params
   *
   * @param  string $code
   * @param  array $params
   * @param  array $data
   * @param  Credentials $credentials API credentials
   *
   * @return self  the updated pricelist
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
    $sxe = $call->execute('pricelists/' . $code, 'PUT', array_intersect_key($params, $allowedParams), $data);

    return $sxe;
  }

  /**
   * Delete single pricelist matching the $code filter
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
    $response = $call->execute('pricelists/' . $code, 'DELETE');

    return $response;
  }
}
