<?php

namespace HolidayLink\Api;

use HolidayLink\Auth\Credentials;
use HolidayLink\Transport\XmlCall;

/**
 * Class User
 * @package HolidayLink\Api
 */
class User extends Model {

  static public $fields = [
    'code',
    'first_name',
    'last_name',
    'company',
    'vat_number',
    'responsible_person',
    'photo',
    'mobilePhone',
    'contactPhones',
    'booking_inquiry_email',
    'contact_email',
    'cooperation_mode',
    'provision_payment_type',
    'country',
    'city',
    'post_code',
    'address',
    'user_comment',
  ];

  /**
   * Retrieve single user matching the $code filter
   *
   * @param  string $code
   * @param  array $params
   * @param  Credentials $credentials API credentials
   *
   * @return Properties  the retrieved user
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
    $sxe = $call->execute('users/' . $code, 'GET', array_intersect_key($params, $allowedParams));

    $ret = new self();
    $ret->fromXML($sxe);

    return $ret;
  }
}
