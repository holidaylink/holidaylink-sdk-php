<?php

namespace HolidayLink\Api;

use HolidayLink\Auth\Credentials;
use HolidayLink\Transport\JsonCall;
use HolidayLink\Transport\SimpleCall;
use HolidayLink\Transport\XmlCall;

/**
 * Class AccommodationUnitFeatureValue
 * @package HolidayLink\Api
 */
class AccommodationUnitFeatureValue extends Model {

  public static $fields = [
      'accommodation',
      'feature',
      'value',
      'accommodationUnitTypeFeatures',
      'accommodation_unit_type_features_child',
      'parent_id',
      'parent',
  ];

  /**
   * Retrieve single accommodation unit feature value matching the $code filter
   *
   * @param  string $code
   * @param  array $params
   * @param  Credentials $credentials API credentials
   *
   * @return self  the retrieved accommodation unit feature value
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
    $sxe = $call->execute('accommodation-unit-feature-values/' . $code, 'GET',
      array_intersect_key($params, $allowedParams));

    $ret = new self();
    $ret->fromXML($sxe);

    return $ret;
  }

  /**
   * Create single accommodation unit feature value matching the $code filter and array of key => value params
   *
   * @param  array $params
   * @param  array $data
   * @param  Credentials $credentials API credentials
   *
   * @return Accommodation unit feature value
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

    $call = new JsonCall($credentials);
    $sxe = $call->execute('accommodation-unit-feature-values', 'POST',
      array_intersect_key($params, $allowedParams), $data);

    return $sxe;
  }


  /**
   * Update single accommodation unit feature value matching the $code filter and array of key => value params
   *
   * @param  string $code
   * @param  array $params
   * @param  array $data
   * @param  Credentials $credentials API credentials
   *
   * @return Accommodation unit feature value
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
    $sxe = $call->execute('accommodation-unit-feature-values/' . $code, 'PUT',
      array_intersect_key($params, $allowedParams), $data);

    return $sxe;
  }

  /**
   * Delete single accommodation unit feature value matching the $code filter
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
    $response = $call->execute('accommodation-unit-feature-values/' . $code, 'DELETE');

    return $response;
  }

}
