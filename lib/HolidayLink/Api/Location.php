<?php

namespace HolidayLink\Api;

/**
 * Class Location
 * @package HolidayLink\Api
 */
class Location extends Model {

  static public $fields = [
    'id',
    'name',
    'map_lat',
    'map_lng',
    'locations',
  ];

}
