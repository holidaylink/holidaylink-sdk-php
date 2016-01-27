<?php
/**
 * This sample demonstrates how to get
 * the available accommodation
 *
 * API action: getAccommodationCategories
 */

require __DIR__ . '/../bootstrap.php';

use HolidayLink\Api\Accommodation;

/**
 * Retrieve the accommodation using optional code, filters and your API credentials
 * (see bootstrap.php for credentials creation)
 */
try {
  $params = array(
    'expand' => 'accommodationCategory, supplier_type, location, postal_code, neighborhood, address, map_lat,
      map_lng, map_zoom, photos, videos, created_at, updated_at',
  );
  //set your own accommodation code, this is only for test purpose
  $code = 'o20';
  $accommodation = Accommodation::singleFromXML($code, $params, $apiCredentials);
} catch (Exception $ex) {
  echo 'Exception:', $ex->getMessage(), PHP_EOL;
  exit(1);
}
?>

<html>
  <head>
    <meta charset="utf-8">
    <title>Get accommodation</title>
  </head>
  <body>
    <div>Got accommodation</div>
    <pre><?php print_r($accommodation->toArray()); ?></pre>
    <a href='../index.htm'>Back</a>
  </body>
</html>
