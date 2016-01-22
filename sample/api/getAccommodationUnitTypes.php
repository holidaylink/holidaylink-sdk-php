<?php
/**
 * This sample demonstrates how to get
 * the available accommodation categories list
 *
 * API action: getAccommodationCategories
 */

require __DIR__ . '/../bootstrap.php';

use HolidayLink\Api\AccommodationUnitTypes;

/**
 * Retrieve the accommodation unit types list using optional filters and your API credentials
 * (see bootstrap.php for credentials creation)
 */
try {
  $params = [];
  $accommodationUnitTypes = AccommodationUnitTypes::allFromXML($params, $apiCredentials);
} catch (Exception $ex) {
  echo 'Exception:', $ex->getMessage(), PHP_EOL;
  exit(1);
}
?>

<html>
  <head>
    <meta charset="utf-8">
    <title>Get accommodation units</title>
  </head>
  <body>
    <div>Got <?php echo $accommodationUnitTypes->getCount(); ?> matching accommodation unit types</div>
    <pre><?php print_r($accommodationUnitTypes->toArray()); ?></pre>
    <a href='../index.htm'>Back</a>
  </body>
</html>
