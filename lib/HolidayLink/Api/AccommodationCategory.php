<?php

namespace HolidayLink\Api;

/**
 * Class AccommodationCategory
 * @package HolidayLink\Api
 */
class AccommodationCategory extends Model {

  static public $fields = [
    'code',
    'title',
    'description',
    'accommodationUnitTypes',
  ];

}
