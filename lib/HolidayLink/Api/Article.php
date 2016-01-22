<?php

namespace HolidayLink\Api;

/**
 * Class Article
 * @package HolidayLink\Api
 */
class Article extends Model {

  static public $fields = [
    'id',
    'title',
    'location',
    'neighborhood',
    'address',
    'category',
    'creator_id',
    'author_type_id',
    'gps_lat',
    'gps_lng',
    'created_at',
    'updated_at',
    'updater_id',
    'features',
  ];

}
