<?php

namespace HolidayLink\Api;

use HolidayLink\Auth\Credentials;

/**
 * Class Model
 * @package HolidayLink\Api
 */
abstract class Model {

  /**
   * HolidayLink API credentials
   */
  private static $credentials;

  /**
   * The model data
   * @var array
   */
  private $_data = array();

  public function __get ($key) {
    return $this->_data[$key];
  }

  public function __set ($key, $value) {
    $this->_data[$key] = $value;
  }

  public function __isset ($key) {
    return isset($this->_data[$key]);
  }

  public function __unset ($key) {
    unset($this->_data[$key]);
  }

  public function setData ($data) {
    $this->_data = $data;
  }

  /**
   * Returns the results as array
   *
   * @return array the results
   */
  public function toArray () {
    return $this->_convertToArray($this->_data);
  }

  /**
   * Returns the $param as array
   *
   * @param  mixed $param
   *
   * @return array
   */
  private function _convertToArray ($param) {
    $ret = array();
    foreach ($param as $key => $value) {
      if ($value instanceof self) {
        $ret[$key] = $value->toArray();
      } else {
        if (is_array($value)) {
          $ret[$key] = $this->_convertToArray($value);
        } else {
          $ret[$key] = $value;
        }
      }
    }

    return $ret;
  }

  /**
   * Set API credentials
   *
   * @param Credentials $credentials
   */
  public static function setCredentials (Credentials $credentials) {
    self::$credentials = $credentials;
  }

  /**
   * Returns API credentials
   *
   * @return mixed
   */
  public static function getCredentials () {
    return self::$credentials;
  }

  /**
   * Parse entity from XML
   *
   * @param \SimpleXMLElement $entity
   */
  public function fromXML (\SimpleXMLElement $entity) {
    $entity = json_decode(json_encode($entity), 1);
    $this->setData($entity);
  }

}
