<?php

namespace HolidayLink\Api;

/**
 * Class CreditCard
 * @package HolidayLink\Api
 */
class CreditCard extends Model {

  static public $fields = [
    'id',
    'status',
    'created_at',
    'updated_at',
    'creator_id',
    'updater_id',
    'title',
  ];

}
