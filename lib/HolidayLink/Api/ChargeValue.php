<?php

namespace HolidayLink\Api;

/**
 * Class ChargeValue
 * @package HolidayLink\Api
 */
class ChargeValue extends Model {

  static public $fields = [
    'id',
    'charge',
    'status',
    'amount',
    'accommodationUnit',
    'calculation_type',
    'calculation_timing',
    'calculation_per_item',
    'created_at',
    'updated_at',
  ];

}
