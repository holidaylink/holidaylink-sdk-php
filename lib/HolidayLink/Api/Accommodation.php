<?php

namespace HolidayLink\Api;

/**
 * Class Accommodation
 * @package HolidayLink\Api
 */
class Accommodation extends Model {

  static public $fields = [
    'status',
    'code',
    'title',
    'accommodationCategory',
    'supplier_type',
    'location',
    'postal_code',
    'neighborhood',
    'address',
    'map_lat',
    'map_lng',
    'map_zoom',
    'photos',
    'videos',
    'created_at',
    'updated_at',
  ];

}
