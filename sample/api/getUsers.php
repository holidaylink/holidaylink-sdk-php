<?php
/**
 * This sample demonstrates how to get
 * the available accommodation categories list
 *
 * API action: getAccommodationCategories
 */

require __DIR__ . '/../bootstrap.php';

use HolidayLink\Api\Users;

/**
 * Retrieve the accommodation categories list using optional filters and your API credentials
 * (see bootstrap.php for credentials creation)
 */
try {
  $params = array(
    'expand' => 'photo, vat_number',
  );
  $users = Users::allFromXML($params, $apiCredentials);
} catch (Exception $ex) {
  echo 'Exception:', $ex->getMessage(), PHP_EOL;
  exit(1);
}
?>

<html>
  <head>
    <meta charset="utf-8">
    <title>Get users</title>
  </head>
  <body>
    <div>Got <?php echo $users->getCount(); ?> matching users</div>
    <pre><?php print_r($users->toArray()); ?></pre>
    <a href='../index.htm'>Back</a>
  </body>
</html>
