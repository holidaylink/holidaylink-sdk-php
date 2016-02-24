<?php

namespace HolidayLink\Api;

use HolidayLink\Auth\Credentials;
use HolidayLink\Transport\XmlCall;

/**
 * Class Users
 * @package HolidayLink\Api
 */
class Users extends Model {

  /**
   * Number of users returned
   * @var integer
   */
  private $count = 0;

  /**
   * Returns the users count
   * @return int
   */
  public function getCount () {
    return $this->count;
  }

  /**
   * Create users from XML
   *
   * @param  \SimpleXMLElement $sxe the API response
   *
   * @return $this
   */
  public function fromXML (\SimpleXMLElement $sxe) {
    $users = array();
    $this->count = 0;

    foreach ($sxe->children() as $userEntity) {
      $user = new User();
      $user->fromXml($userEntity);
      $users[] = $user;
      ++$this->count;
    }
    $this->setData($users);

    return $this;
  }

  /**
   * Retrieve all users matching the $params filter
   *
   * @param  array $params filter parameters (role, status)
   * @param  Credentials $credentials API credentials
   *
   * @return $this
   */
  public static function allFromXML (array $params = null, Credentials $credentials = null) {
    if (empty($params)) {
      $params = array();
    }
    if (!empty($credentials)) {
      self::setCredentials($credentials);
    }
    $allowedParams = array(
      'expand' => 1,
      'language' => 1,
      'page' => 1,
    );

    $wrongParams = array_diff_key($params, $allowedParams);
    if (!empty($wrongParams)) {
      throw new \InvalidArgumentException('Invalid $params filter: ' . implode(', ', array_keys($wrongParams)));
    }

    $call = new XmlCall($credentials);
    $sxe = $call->execute('users', 'GET', array_intersect_key($params, $allowedParams));
    self::setTotalPageCount($call->getTotalPageCount());

    $ret = new self();
    $ret->fromXML($sxe);

    return $ret;
  }

}
