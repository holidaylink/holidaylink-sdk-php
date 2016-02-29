<?php

namespace HolidayLink\Api;

use HolidayLink\Auth\Credentials;
use HolidayLink\Transport\XmlCall;

/**
 * Class Articles
 * @package HolidayLink\Api
 */
class Articles extends Model {

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
   * Create articles from XML
   *
   * @param  \SimpleXMLElement $sxe the API response
   *
   * @return $this
   */
  public function fromXML (\SimpleXMLElement $sxe) {
    $articles = array();
    $this->count = 0;

    foreach ($sxe->children() as $article) {
      $en = new Article();
      $en->fromXml($article);
      $articles[] = $en;
      ++$this->count;
    }
    $this->setData($articles);

    return $this;
  }

  /**
   * Retrieve all articles matching the $params filter
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
    $sxe = $call->execute('articles', 'GET', array_intersect_key($params, $allowedParams));

    $ret = new self();
    $ret->fromXML($sxe);

    return $ret;
  }

  /**
   * Retrieve all articles matching the $params
   *
   * @param  array $params
   * @param  Credentials $credentials API credentials
   *
   * @return self  the retrieved articles
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
      'location_id' => 1,
      'creator_id' => 1,
      'author_type_id' => 1,
      'gps_lat' => 1,
      'gps_lng' => 1,
      'created_at' => 1,
      'updated_at' => 1,
      'updater_id' => 1,
    );

    $wrongParams = array_diff_key($params, $allowedParams);
    if (!empty($wrongParams)) {
      throw new \InvalidArgumentException('Invalid $params filter: ' . implode(', ', array_keys($wrongParams)));
    }

    $call = new XmlCall($credentials);
    $sxe = $call->execute('articles/search', 'GET', array_intersect_key($params, $allowedParams));
    self::setTotalPageCount($call->getTotalPageCount());

    $ret = new self();
    $ret->fromXML($sxe);

    return $ret;
  }
}
