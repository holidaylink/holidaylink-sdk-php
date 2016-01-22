<?php
/**
 * This sample demonstrates how to get
 * the available accommodation categories list
 *
 * API action: getAccommodationCategories
 */

require __DIR__ . '/../bootstrap.php';

use HolidayLink\Api\Accommodations;

/**
 * Retrieve the accommodations list using optional filters and your API credentials
 * (see bootstrap.php for credentials creation)
 */
try {
  $params = array(
    'expand' => 'accommodationCategory, supplier_type, location, postal_code, neighborhood, address, map_lat,
      map_lng, map_zoom, photos, videos, created_at, updated_at',
  );
  $accommodations = Accommodations::allFromXML($params, $apiCredentials);
} catch (Exception $ex) {
  echo 'Exception:', $ex->getMessage(), PHP_EOL;
  exit(1);
}
?>

<html>
  <head>
    <meta charset="utf-8">
    <title>Get accommodations</title>
  </head>
  <body>
    <div>Got <?php echo $accommodations->getCount(); ?> matching accommodations</div>
    <pre><?php print_r($accommodations->toArray()); ?></pre>
    <a href='../index.htm'>Back</a>
  </body>
</html>
