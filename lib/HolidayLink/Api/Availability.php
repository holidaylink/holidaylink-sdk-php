<?php

namespace HolidayLink\Api;

use HolidayLink\Auth\Credentials;
use HolidayLink\Transport\JsonCall;
use HolidayLink\Transport\SimpleCall;
use HolidayLink\Transport\XmlCall;

/**
 * Class Availability
 * @package HolidayLink\Api
 */
class Availability extends Model {

  public static $fields = [
    'id',
    'status',
    'start_date',
    'end_date',
    'accommodationUnit',
    'created_at',
    'updated_at',
  ];

  /**
   * status options:
   *  - const STATUS_UNSET = 0
   *  - const STATUS_AVAILABLE = 1
   *  - const STATUS_RESERVED_NOT_PAYED = 2
   *  - const STATUS_RESERVED_PAYED = 3
   *  - const STATUS_RESERVED_BY_AGENCY = 4
   *  - const STATUS_RESERVED_BY_OWNER = 5
   *
   * start_date & end_date format:
   *  - Y-m-d (2016-01-01)
   *
   * @var array
   */
  public static $requiredFields = [
    'status',
    'start_date',
    'end_date',
  ];

  /**
   * Availability statuses
   */
  const STATUS_UNSET = 0;
  const STATUS_AVAILABLE = 1;
  const STATUS_RESERVED_NOT_PAYED = 2;
  const STATUS_RESERVED_PAYED = 3;
  const STATUS_RESERVED_BY_AGENCY = 4;
  const STATUS_RESERVED_BY_OWNER = 5;

  /************************ Additional options **************************
   *
   * Visibility status
   */
  const VISIBILITY_STATUS_ACTIVE = 'active';
  const VISIBILITY_STATUS_DISABLED = 'disabled';

  /**
   * Retrieve single availability matching the $code filter
   *
   * @param  string $code
   * @param  array $params
   * @param  Credentials $credentials API credentials
   *
   * @return self  the retrieved availability
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
    $sxe = $call->execute('availability/' . $code, 'GET', array_intersect_key($params, $allowedParams));

    $ret = new self();
    $ret->fromXML($sxe);

    return $ret;
  }

  /**
   * Create single availability from array of key => value params
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
    $sxe = $call->execute('availabilities', 'POST', array_intersect_key($params, $allowedParams), $data);

    return $sxe;
  }

  /**
   * Update single availability matching the $code filter and array of key => value params
   *
   * @param  string $code
   * @param  array $params
   * @param  array $data
   * @param  Credentials $credentials API credentials
   *
   * @return self  the updated availability
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
    $sxe = $call->execute('availabilities/' . $code, 'PUT', array_intersect_key($params, $allowedParams), $data);

    return $sxe;
  }

  /**
   * Delete single availability matching the $code filter
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
    $response = $call->execute('availabilities/' . $code, 'DELETE');

    return $response;
  }
}
