<?php

require __DIR__ . '/../bootstrap.php';

use HolidayLink\Api\AccommodationUnit;

/**
 * Create the accommodation using optional code and your API credentials
 * (see bootstrap.php for credentials creation)
 */
try {
  // provide some params for expand - preview in response
  $params = [
    'expand' => '',
  ];
  // provide data for update - array with key => value structure
  /**
   ****************************** IMPORTANT *******************************
   * required params:
   *  - title
   *  - accommodation_id
   *  - accommodation_unit_type_id
   */
  $data = [
    'title' => 'test accommodation unit',
    'accommodation_id' => 71,
    'accommodation_unit_type_id' => 3,
  ];

  $accommodationUnit = AccommodationUnit::createSingle($params, $data, $apiCredentials);
} catch (Exception $ex) {
  echo 'Exception:', $ex->getMessage(), PHP_EOL;
  exit(1);
}
?>

<html>
  <head>
    <meta charset="utf-8">
    <title>Accommodation unit create</title>
  </head>
  <body>
    <div>Accommodation unit created</div>
    <pre><?php print_r($accommodationUnit); ?></pre>
    <a href='../index.htm'>Back</a>
  </body>
</html>
