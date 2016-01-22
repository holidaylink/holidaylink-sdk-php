<?php

namespace HolidayLink\Api;

/**
 * Class FeatureValue
 * @package HolidayLink\Api
 */
class FeatureValue extends Model {

  static public $fields = [
    'code',
    'title',
    'feature',
    'default_value',
    'show_on_list',
    'api_wrapper',
  ];

}
