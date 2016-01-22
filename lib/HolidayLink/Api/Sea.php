<?php

namespace HolidayLink\Api;

/**
 * Class Sea
 * @package HolidayLink\Api
 */
class Sea extends Model {

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
