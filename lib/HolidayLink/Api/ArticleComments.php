<?php

namespace HolidayLink\Api;

use HolidayLink\Auth\Credentials;
use HolidayLink\Transport\XmlCall;

/**
 * Class ArticleComments
 * @package HolidayLink\Api
 */
class ArticleComments extends Model {

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
   * Create article comments from XML
   *
   * @param  \SimpleXMLElement $sxe the API response
   *
   * @return $this
   */
  public function fromXML (\SimpleXMLElement $sxe) {
    $articleComments = array();
    $this->count = 0;

    foreach ($sxe->children() as $articleComment) {
      $en = new ArticleComment();
      $en->fromXml($articleComment);
      $articleComments[] = $en;
      ++$this->count;
    }
    $this->setData($articleComments);

    return $this;
  }

  /**
   * Retrieve all article comments matching the $params filter
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
    );

    $wrongParams = array_diff_key($params, $allowedParams);
    if (!empty($wrongParams)) {
      throw new \InvalidArgumentException('Invalid $params filter: ' . implode(', ', array_keys($wrongParams)));
    }

    $call = new XmlCall($credentials);
    $sxe = $call->execute('article-comments', array_intersect_key($params, $allowedParams));

    $ret = new self();
    $ret->fromXML($sxe);

    return $ret;
  }
}
