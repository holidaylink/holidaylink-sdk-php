<?php

namespace HolidayLink\Api;

/**
 * Class DiscountValue
 * @package HolidayLink\Api
 */
class DiscountValue extends Model {

  static public $fields = [
    'id',
    'discount',
    'status',
    'amount',
    'accommodationUnit',
    'created_at',
    'updated_at',
  ];

}
