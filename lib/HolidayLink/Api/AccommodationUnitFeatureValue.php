<?php

namespace HolidayLink\Api;

/**
 * Class AccommodationUnitFeatureValue
 * @package HolidayLink\Api
 */
class AccommodationUnitFeatureValue extends Model {

  static public $fields = [
    'accommodation',
    'feature',
    'value',
    'accommodationUnitTypeFeatures',
    'accommodation_unit_type_features_child',
    'parent_id',
    'parent',
  ];

}
