<?php

namespace HolidayLink\Api;

/**
 * Class Feature
 * @package HolidayLink\Api
 */
class Feature extends Model {

  static public $fields = [
    'featureValues',
    'required',
    'displayEmpty',
    'restriction',
    'default_value',
    'show_on_list',
    'description',
    'api_wrapper',
  ];

}
