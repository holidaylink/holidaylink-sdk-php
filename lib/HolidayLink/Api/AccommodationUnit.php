<?php

namespace HolidayLink\Api;

/**
 * Class AccommodationUnit
 * @package HolidayLink\Api
 */
class AccommodationUnit extends Model {

  static public $fields = [
    'status',
    'code',
    'title',
    'accommodationUnitType',
    'cooperation_mode',
    'count',
    'created_at',
    'updated_at',
  ];

}
