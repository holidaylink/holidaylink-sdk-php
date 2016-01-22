<?php

namespace HolidayLink\Api;

/**
 * Class Discount
 * @package HolidayLink\Api
 */
class Discount extends Model {

  static public $fields = [
    'id',
    'title',
    'types',
    'allowedCategories',
  ];

}
