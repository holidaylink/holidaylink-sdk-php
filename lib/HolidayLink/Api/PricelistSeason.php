<?php

namespace HolidayLink\Api;

/**
 * Class PricelistSeason
 * @package HolidayLink\Api
 */
class PricelistSeason extends Model {

  static public $fields = [
    'id',
    'accommodation',
    'date_arrival',
    'date_departure',
    'nights_minimal',
    'allowed_arrival_day',
    'created_at',
    'updated_at',
  ];

}
