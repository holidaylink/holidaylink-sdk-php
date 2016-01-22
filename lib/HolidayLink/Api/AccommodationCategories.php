<?php

namespace HolidayLink\Api;

use HolidayLink\Auth\Credentials;
use HolidayLink\Transport\XmlCall;

/**
 * Class AccommodationCategories
 * @package HolidayLink\Api
 */
class AccommodationCategories extends Model {

  /**
   * Number of categories returned
   * @var integer
   */
  private $count = 0;

  /**
   * Returns the categories count
   * @return int
   */
  public function getCount () {
    return $this->count;
  }

  /**
   * Create categories from XML
   *
   * @param  \SimpleXMLElement $sxe the API response
   *
   * @return Properties
   */
  public function fromXML (\SimpleXMLElement $sxe) {
    $categories = array();
    $this->count = 0;

    foreach ($sxe->children() as $category) {
      $cat = new AccommodationCategory();
      $cat->fromXml($category);
      $categories[] = $cat;
      ++$this->count;
    }
    $this->setData($categories);

    return $this;
  }

  /**
   * Retrieve all categories matching the $params filter
   *
   * @param  array $params
   * @param  Credentials $credentials API credentials
   *
   * @return Properties  the retrieved categories
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
    );

    $wrongParams = array_diff_key($params, $allowedParams);
    if (!empty($wrongParams)) {
      throw new \InvalidArgumentException('Invalid $params filter: ' . implode(', ', array_keys($wrongParams)));
    }

    $call = new XmlCall($credentials);
    $sxe = $call->execute('accommodation-categories', array_intersect_key($params, $allowedParams));

    $ret = new self();
    $ret->fromXML($sxe);

    return $ret;
  }
}
