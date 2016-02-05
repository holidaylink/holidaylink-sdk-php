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
  // provide some params for expand - preview in response
  $params = [
    'expand' => 'postal_code',
  ];
  // provide data for update - array with key => value structure
  $data = [
    'title' => 'test',
    'postal_code' => '12345',
  ];

  //set your own accommodation code, this is only for test purpose
  $code = 'your code';
  $accommodation = Accommodation::updateSingle($code, $params, $data, $apiCredentials);
} catch (Exception $ex) {
  echo 'Exception:', $ex->getMessage(), PHP_EOL;
  exit(1);
}
?>

<html>
  <head>
    <meta charset="utf-8">
    <title>Accommodation update</title>
  </head>
  <body>
    <div>Accommodation updated</div>
    <pre><?php print_r($accommodation); ?></pre>
    <a href='../index.htm'>Back</a>
  </body>
</html>
