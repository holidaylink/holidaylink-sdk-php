<?php
/**
 * This sample demonstrates how to get
 * the available accommodation categories list
 *
 * API action: getAccommodationCategories
 */

require __DIR__ . '/../bootstrap.php';

use HolidayLink\Api\AccommodationFeatureValues;

/**
 * Retrieve the accommodation feature values list using optional filters and your API credentials
 * (see bootstrap.php for credentials creation)
 */
try {
  $params = [];
  $accommodationFeatureValues = AccommodationFeatureValues::allFromXML($params, $apiCredentials);
} catch (Exception $ex) {
  echo 'Exception:', $ex->getMessage(), PHP_EOL;
  exit(1);
}
?>

<html>
  <head>
    <meta charset="utf-8">
    <title>Get accommodation feature values</title>
  </head>
  <body>
    <div>Got <?php echo $accommodationFeatureValues->getCount(); ?> matching accommodation feature values</div>
    <pre><?php print_r($accommodationFeatureValues->toArray()); ?></pre>
    <a href='../index.htm'>Back</a>
  </body>
</html>
