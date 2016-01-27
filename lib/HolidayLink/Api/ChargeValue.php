<?php

namespace HolidayLink\Api;

use HolidayLink\Auth\Credentials;
use HolidayLink\Transport\XmlCall;

/**
 * Class ChargeValue
 * @package HolidayLink\Api
 */
class ChargeValue extends Model {

  static public $fields = [
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
   * Retrieve single charge value matching the $code filter
   *
   * @param  string $code
   * @param  array $params
   * @param  Credentials $credentials API credentials
   *
   * @return Properties  the retrieved charge value
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
}
