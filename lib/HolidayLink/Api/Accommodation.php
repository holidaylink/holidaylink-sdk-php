<?php

namespace HolidayLink\Api;

use HolidayLink\Transport\JsonCall;
use HolidayLink\Auth\Credentials;
use HolidayLink\Transport\SimpleCall;
use HolidayLink\Transport\XmlCall;

/**
 * Class Accommodation
 * @package HolidayLink\Api
 */
class Accommodation extends Model {

  public static $fields = [
    'status',
    'code',
    'title',
    'accommodationCategory',
    'supplier_type',
    'location',
    'postal_code',
    'neighborhood',
    'address',
    'map_lat',
    'map_lng',
    'map_zoom',
    'photos',
    'videos',
    'created_at',
    'updated_at',
  ];

  /**
   * accommodation_category_id options:
   *  - use id keys from AccommodationCategorys::allFromXML()
   *
   * location_id options:
   *  - use id keys from Location::allFromXML()
   *  - use just keys of cities (country and region will be defined automatically)
   *
   * @var array
   */
  public static $requiredFields = [
    'title',
    'accommodation_category_id',
    'location_id',
  ];

  /************************ Additional options **************************
   *
   * Accommodation statuses
   */
  const STATUS_ACTIVE = 'active';
  const STATUS_DISABLED = 'disabled';

  /**
   * Supplier types
   */
  const SUPPLIER_TYPE_OWNER = 'owner';
  const SUPPLIER_TYPE_MANAGER = 'manager';
  const SUPPLIER_TYPE_AGENCY = 'agency';

  /**
   * Retrieve single accommodation matching the $code filter
   *
   * @param  string $code
   * @param  array $params
   * @param  Credentials $credentials API credentials
   *
   * @return self  the retrieved accommodation
   */
  public static function singleFromXML ($code, array $params = [], Credentials $credentials = null) {
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
    $sxe = $call->execute('accommodations/' . $code, 'GET', array_intersect_key($params, $allowedParams));

    $ret = new self();
    $ret->fromXML($sxe);

    return $ret;
  }

  /**
   * Create single accommodation from array of key => value params
   *
   * @param  array $params
   * @param  array $data
   * @param  Credentials $credentials API credentials
   *
   * @return Accommodation
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
    $sxe = $call->execute('accommodations', 'POST', array_intersect_key($params, $allowedParams), $data);

    return $sxe;
  }

  /**
   * Update single accommodation matching the $code filter and array of key => value params
   *
   * @param  string $code
   * @param  array $params
   * @param  array $data
   * @param  Credentials $credentials API credentials
   *
   * @return Accommodation
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
    $sxe = $call->execute('accommodations/' . $code, 'PUT', array_intersect_key($params, $allowedParams), $data);

    return $sxe;
  }

  /**
   * Delete single accommodation matching the $code filter
   *
   * @param  string $code
   * @param  Credentials $credentials API credentials
   *
   * @return bool
   */
  public static function deleteSingle ($code, Credentials $credentials = null) {

    if (!empty($credentials)) {
      self::setCredentials($credentials);
    }

    $call = new SimpleCall($credentials);
    $response = $call->execute('accommodations/' . $code, 'DELETE');

    return $response;
  }

}
