<?php

namespace HolidayLink\Api;

/**
 * Class AccommodationFeatureValue
 * @package HolidayLink\Api
 */
class AccommodationFeatureValue extends Model {

  static public $fields = [
    'accommodation',
    'feature',
    'value',
    'accommodationCategoryFeatures',
    'accommodation_category_features_child',
    'parent_id',
    'parent',
  ];

}
