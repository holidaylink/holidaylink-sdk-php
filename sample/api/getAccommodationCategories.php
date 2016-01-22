<?php
/**
 * This sample demonstrates how to get
 * the available accommodation categories list
 *
 * API action: getAccommodationCategories
 */

require __DIR__ . '/../bootstrap.php';

use HolidayLink\Api\AccommodationCategories;

/**
 * Retrieve the accommodation categories list using optional filters and your API credentials
 * (see bootstrap.php for credentials creation)
 */
try {
  $params = [];
  $accommodationCategories = AccommodationCategories::allFromXML($params, $apiCredentials);
} catch (Exception $ex) {
  echo 'Exception:', $ex->getMessage(), PHP_EOL;
  exit(1);
}
?>

<html>
  <head>
    <meta charset="utf-8">
    <title>Get accommodation categories</title>
  </head>
  <body>
    <div>Got <?php echo $accommodationCategories->getCount(); ?> matching accommodation categories</div>
    <pre><?php print_r($accommodationCategories->toArray()); ?></pre>
    <a href='../index.htm'>Back</a>
  </body>
</html>
