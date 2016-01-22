<?php
/**
 * This sample demonstrates how to get
 * the available accommodation categories list
 *
 * API action: getAccommodationCategories
 */

require __DIR__ . '/../bootstrap.php';

use HolidayLink\Api\AccommodationUnits;

/**
 * Retrieve the accommodations list using optional filters and your API credentials
 * (see bootstrap.php for credentials creation)
 */
try {
  $params = array(
    'expand' => 'created_at, cooperation_mode, count, updated_at, accommodationUnitType',
  );
  $accommodationUnits = AccommodationUnits::allFromXML($params, $apiCredentials);
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
    <div>Got <?php echo $accommodationUnits->getCount(); ?> matching accommodation units</div>
    <pre><?php print_r($accommodationUnits->toArray()); ?></pre>
    <a href='../index.htm'>Back</a>
  </body>
</html>
