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
 * Retrieve the accommodations supplier types your API credentials
 * (see bootstrap.php for credentials creation)
 */
try {
  $accommodationSupplierTypes = Accommodations::supplierTypes($apiCredentials);
} catch (Exception $ex) {
  echo 'Exception:', $ex->getMessage(), PHP_EOL;
  exit(1);
}
?>

<html>
  <head>
    <meta charset="utf-8">
    <title>Get accommodations supplier types</title>
  </head>
  <body>
    <div>Got accommodations supplier types</div>
    <pre><?php print_r($accommodationSupplierTypes); ?></pre>
    <a href='../index.htm'>Back</a>
  </body>
</html>
