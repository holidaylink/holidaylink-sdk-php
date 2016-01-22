<?php
/**
 * This sample demonstrates how to get
 * the available accommodation categories list
 *
 * API action: getAccommodationCategories
 */

require __DIR__ . '/../bootstrap.php';

use HolidayLink\Api\Actions;

/**
 * Retrieve the actions list using optional filters and your API credentials
 * (see bootstrap.php for credentials creation)
 */
try {
  $params = [];
  $actions = Actions::allFromXML($params, $apiCredentials);
} catch (Exception $ex) {
  echo 'Exception:', $ex->getMessage(), PHP_EOL;
  exit(1);
}
?>

<html>
  <head>
    <meta charset="utf-8">
    <title>Get actions</title>
  </head>
  <body>
    <div>Got <?php echo $actions->getCount(); ?> matching actions</div>
    <pre><?php print_r($actions->toArray()); ?></pre>
    <a href='../index.htm'>Back</a>
  </body>
</html>
