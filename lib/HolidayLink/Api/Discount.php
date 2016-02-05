<?php

namespace HolidayLink\Api;

use HolidayLink\Auth\Credentials;
use HolidayLink\Transport\JsonCall;
use HolidayLink\Transport\SimpleCall;
use HolidayLink\Transport\XmlCall;

/**
 * Class Discount
 * @package HolidayLink\Api
 */
class Discount extends Model {

  public static $fields = [
    'id',
    'title',
    'types',
    'allowedCategories',
  ];

  /**
   * Discount statuses
   */
  const STATUS_ACTIVE = 'active';
  const STATUS_DISABLED = 'disabled';

  /**
   * Discount statuses for partner
   */
  const STATUS_ACTIVE_FOR_PARTNER = 'active';
  const STATUS_DISABLED_FOR_PARTNER = 'disabled';
  /**
   * Retrieve single discount matching the $code filter
   *
   * @param  string $code
   * @param  array $params
   * @param  Credentials $credentials API credentials
   *
   * @return self  the retrieved discount
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
    $sxe = $call->execute('discounts/' . $code, 'GET', array_intersect_key($params, $allowedParams));

    $ret = new self();
    $ret->fromXML($sxe);

    return $ret;
  }

  /**
   * Update single discount matching the $code filter and array of key => value params
   *
   * @param  string $code
   * @param  array $params
   * @param  array $data
   * @param  Credentials $credentials API credentials
   *
   * @return self  the updated disocunt
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
    $sxe = $call->execute('discounts/' . $code, 'PUT', array_intersect_key($params, $allowedParams), $data);

    return $sxe;
  }

  /**
   * Delete single discount matching the $code filter
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
    $response = $call->execute('discounts/' . $code, 'DELETE');

    return $response;
  }
}
