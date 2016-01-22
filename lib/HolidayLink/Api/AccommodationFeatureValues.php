<?php

namespace HolidayLink\Api;

use HolidayLink\Auth\Credentials;
use HolidayLink\Transport\XmlCall;

/**
 * Class AccommodationFeatureValues
 * @package HolidayLink\Api
 */
class AccommodationFeatureValues extends Model {

  /**
   * Number of returned
   * @var integer
   */
  private $count = 0;

  /**
   * Returns the count
   * @return int
   */
  public function getCount () {
    return $this->count;
  }

  /**
   * Create accommodation feature values from XML
   *
   * @param  \SimpleXMLElement $sxe the API response
   *
   * @return Properties
   */
  public function fromXML (\SimpleXMLElement $sxe) {
    $accommodationFeatureValues = array();
    $this->count = 0;

    foreach ($sxe->children() as $accommodationFeatureValue) {
      $cat = new AccommodationFeatureValue();
      $cat->fromXml($accommodationFeatureValue);
      $accommodationFeatureValues[] = $cat;
      ++$this->count;
    }
    $this->setData($accommodationFeatureValues);

    return $this;
  }

  /**
   * Retrieve all accommodation feature values matching the $params filter
   *
   * @param  array $params
   * @param  Credentials $credentials API credentials
   *
   * @return Properties the retrieved categories
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
    $sxe = $call->execute('accommodation-feature-values', array_intersect_key($params, $allowedParams));

    $ret = new self();
    $ret->fromXML($sxe);

    return $ret;
  }
}
