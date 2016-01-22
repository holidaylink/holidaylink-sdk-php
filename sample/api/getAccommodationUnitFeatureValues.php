<?php
/**
 * This sample demonstrates how to get
 * the available accommodation categories list
 *
 * API action: getAccommodationCategories
 */

require __DIR__ . '/../bootstrap.php';

use HolidayLink\Api\AccommodationUnitFeatureValues;

/**
 * Retrieve the accommodation unit feature values list using optional filters and your API credentials
 * (see bootstrap.php for credentials creation)
 */
try {
  $params = [];
  $accommodationUnitFeatureValues = AccommodationUnitFeatureValues::allFromXML($params, $apiCredentials);
} catch (Exception $ex) {
  echo 'Exception:', $ex->getMessage(), PHP_EOL;
  exit(1);
}
?>

<html>
  <head>
    <meta charset="utf-8">
    <title>Get accommodation unit feature values</title>
  </head>
  <body>
    <div>Got <?php echo $accommodationUnitFeatureValues->getCount(); ?> matching accommodation unit feature values</div>
    <pre><?php print_r($accommodationUnitFeatureValues->toArray()); ?></pre>
    <a href='../index.htm'>Back</a>
  </body>
</html>
