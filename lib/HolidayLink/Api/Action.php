<?php

namespace HolidayLink\Api;

/**
 * Class User
 * @package HolidayLink\Api
 */
class Action extends Model {

  static public $fields = [
    'id',
    'status',
    'type',
    'amount',
    'accommodationUnit',
    'visible_from',
    'visible_to',
    'applicable_from',
    'applicable_to',
    'created_at',
    'updated_at',
  ];

}
