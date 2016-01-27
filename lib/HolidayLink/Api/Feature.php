<?php

namespace HolidayLink\Api;

use HolidayLink\Auth\Credentials;
use HolidayLink\Transport\XmlCall;

/**
 * Class Feature
 * @package HolidayLink\Api
 */
class Feature extends Model {

  static public $fields = [
    'code',
    'type',
    'title',
    'featureValues',
    'required',
    'displayEmpty',
    'restriction',
    'default_value',
    'show_on_list',
    'description',
    'api_wrapper',
  ];

  /**
   * Retrieve single feature matching the $code filter
   *
   * @param  string $code
   * @param  array $params
   * @param  Credentials $credentials API credentials
   *
   * @return Properties  the retrieved feature
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
    $sxe = $call->execute('features/' . $code, 'GET', array_intersect_key($params, $allowedParams));

    $ret = new self();
    $ret->fromXML($sxe);

    return $ret;
  }
}
