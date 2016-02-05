<?php
/**
 * This sample demonstrates how to get
 * the available accommodation categories list
 *
 * API action: getAccommodationCategories
 */

require __DIR__ . '/../bootstrap.php';

use HolidayLink\Api\Locations;

/**
 * Retrieve the accommodation categories list using optional filters and your API credentials
 * (see bootstrap.php for credentials creation)
 */
try {
  $params = array(
    'expand' => '',
  );
  $locations = Locations::allFromXML($params, $apiCredentials);
} catch (Exception $ex) {
  echo 'Exception:', $ex->getMessage(), PHP_EOL;
  exit(1);
}
?>

<html>
  <head>
    <meta charset="utf-8">
    <title>Get locations</title>
  </head>
  <body>
    <div>Got <?php echo $locations->getCount(); ?> matching locations</div>
    <pre><?php print_r($locations->toArray()); ?></pre>
    <a href='../index.htm'>Back</a>
  </body>
</html>
