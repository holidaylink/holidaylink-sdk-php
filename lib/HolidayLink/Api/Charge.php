<?php

namespace HolidayLink\Api;

/**
 * Class Charge
 * @package HolidayLink\Api
 */
class Charge extends Model {

  static public $fields = [
    'id',
    'title',
    'types',
    'calculationTiming',
    'calculationPerItem',
    'allowedCategories',
  ];

}
