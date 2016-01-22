<?php

namespace HolidayLink\Api;

/**
 * Class Pricelist
 * @package HolidayLink\Api
 */
class Pricelist extends Model {

  static public $fields = [
    'id',
    'accommodationUnit',
    'date_arrival',
    'date_departure',
    'nights_minimal',
    'allowed_arrival_day',
    'method',
    'min_persons',
    'max_persons',
    'price',
    'created_at',
    'updated_at',
  ];

}
