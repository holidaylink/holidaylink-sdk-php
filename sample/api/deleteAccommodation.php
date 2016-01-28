<?php
/**
 * This sample demonstrates how to delete accommodation
 *
 * API action: deleteAccommodation
 */

require __DIR__ . '/../bootstrap.php';

use HolidayLink\Api\Accommodation;

/**
 * Delete the accommodation using optional code and your API credentials
 * (see bootstrap.php for credentials creation)
 */
try {
  //set your own accommodation code, this is only for test purpose
  $code = 'o31';
  $accommodation = Accommodation::deleteSingle($code, $apiCredentials);
} catch (Exception $ex) {
  echo 'Exception:', $ex->getMessage(), PHP_EOL;
  exit(1);
}
?>

<html>
  <head>
    <meta charset="utf-8">
    <title>Accommodation delete</title>
  </head>
  <body>
    <div>Accommodation deleted</div>
    <pre><?php if ($accommodation) {
        print_r('Successful delete operation!');
      } else {
        print_r('Unsuccessful deletion!');
      } ?></pre>
    <a href='../index.htm'>Back</a>
  </body>
</html>
