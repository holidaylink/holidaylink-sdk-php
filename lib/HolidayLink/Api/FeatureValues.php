<?php

namespace HolidayLink\Api;

use HolidayLink\Auth\Credentials;
use HolidayLink\Transport\XmlCall;

/**
 * Class FeatureValues
 * @package HolidayLink\Api
 */
class FeatureValues extends Model {

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
   * Create feature values from XML
   *
   * @param  \SimpleXMLElement $sxe the API response
   *
   * @return $this
   */
  public function fromXML (\SimpleXMLElement $sxe) {
    $featureValues = array();
    $this->count = 0;

    foreach ($sxe->children() as $featureValue) {
      $en = new FeatureValue();
      $en->fromXml($featureValue);
      $featureValues[] = $en;
      ++$this->count;
    }
    $this->setData($featureValues);

    return $this;
  }

  /**
   * Retrieve all feature values matching the $params filter
   *
   * @param  array $params filter parameters
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
    $sxe = $call->execute('feature-values', 'GET', array_intersect_key($params, $allowedParams));
    self::setTotalPageCount($call->getTotalPageCount());

    $ret = new self();
    $ret->fromXML($sxe);

    return $ret;
  }

  /**
   * Retrieve all feature values matching the $params
   *
   * @param  array $params
   * @param  Credentials $credentials API credentials
   *
   * @return self  the retrieved feature values
   */
  public static function search (array $params = null, Credentials $credentials = null) {
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
      'id' => 1,
      'code' => 1,
      'feature_id' => 1,
      'default_value' => 1,
      'title' => 1,
      'show_on_list' => 1,
    );

    $wrongParams = array_diff_key($params, $allowedParams);
    if (!empty($wrongParams)) {
      throw new \InvalidArgumentException('Invalid $params filter: ' . implode(', ', array_keys($wrongParams)));
    }

    $call = new XmlCall($credentials);
    $sxe = $call->execute('feature-values/search', 'GET', array_intersect_key($params, $allowedParams));
    self::setTotalPageCount($call->getTotalPageCount());

    $ret = new self();
    $ret->fromXML($sxe);

    return $ret;
  }
}
