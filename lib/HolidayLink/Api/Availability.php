<?php

namespace HolidayLink\Api;

/**
 * Class Availability
 * @package HolidayLink\Api
 */
class Availability extends Model {

  static public $fields = [
    'id',
    'status',
    'start_date',
    'end_date',
    'accommodationUnit',
    'created_at',
    'updated_at',
  ];

}
