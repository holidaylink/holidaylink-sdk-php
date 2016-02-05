<?php

namespace HolidayLink\Api;

use HolidayLink\Auth\Credentials;
use HolidayLink\Transport\JsonCall;
use HolidayLink\Transport\SimpleCall;
use HolidayLink\Transport\XmlCall;

/**
 * Class AccommodationUnit
 * @package HolidayLink\Api
 */
class AccommodationUnit extends Model {

  public static $fields = [
    'status',
    'code',
    'title',
    'accommodationUnitType',
    'cooperation_mode',
    'count',
    'created_at',
    'updated_at',
  ];

  /**
   * accommodation_id options:
   *  - use id keys from Accommodations::allFromXML()
   *
   * accommodation_unit_type_id options:
   *  - use id keys from AccommodationUnitTypes::allFromXML()
   *
   * @var array
   */
  public static $requiredFields = [
    'title',
    'accommodation_id',
    'accommodation_unit_type_id',
  ];

  /************************ Additional options **************************
   *
   * Accommodation unit status
   */
  const STATUS_ACTIVE = 'active';
  const STATUS_DISABLED = 'disabled';

  /**
   * Accommodation unit cooperation modes
   */
  const COOPERATION_MODE_BOOKING = 'booking';
  const COOPERATION_MODE_INQUIRY = 'inquiry';

  /**
   * Retrieve single accommodation unit matching the $code filter
   *
   * @param  string $code
   * @param  array $params
   * @param  Credentials $credentials API credentials
   *
   * @return self  the retrieved accommodation unit
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
    $sxe = $call->execute('accommodation-units/' . $code, 'GET', array_intersect_key($params, $allowedParams));

    $ret = new self();
    $ret->fromXML($sxe);

    return $ret;
  }

  /**
   * Create single accommodation unit from array of key => value params
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
    $sxe = $call->execute('accommodation-units', 'POST', array_intersect_key($params, $allowedParams), $data);

    return $sxe;
  }

  /**
   * Update single accommodation unit matching the $code filter and array of key => value params
   *
   * @param  string $code
   * @param  array $params
   * @param  array $data
   * @param  Credentials $credentials API credentials
   *
   * @return self  the updated accommodation unit
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
    $sxe = $call->execute('accommodation-units/' . $code, 'PUT', array_intersect_key($params, $allowedParams), $data);

    return $sxe;
  }

  /**
   * Delete single accommodation unit matching the $code filter
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
    $response = $call->execute('accommodation-units/' . $code, 'DELETE');

    return $response;
  }
}
