<?php

require __DIR__ . '/../bootstrap.php';

use HolidayLink\Api\Accommodation;

/**
 * Create the accommodation using optional code and your API credentials
 * (see bootstrap.php for credentials creation)
 */
try {
  // provide some params for expand - preview in response
  $params = [
    'expand' => 'postal_code',
  ];
  // provide data for update - array with key => value structure
  /**
   ****************************** IMPORTANT *******************************
   * required params:
   *  - title
   *  - accommodation_category_id
   *  - location_id (use just ids from cities, NOT region or country id)
   */
  $data = [
    'title' => 'test accommodation',
    'postal_code' => '12345',
    'accommodation_category_id' => 1,
    'location_id' => 16,
  ];

  $accommodation = Accommodation::createSingle($params, $data, $apiCredentials);
} catch (Exception $ex) {
  echo 'Exception:', $ex->getMessage(), PHP_EOL;
  exit(1);
}
?>

<html>
  <head>
    <meta charset="utf-8">
    <title>Accommodation create</title>
  </head>
  <body>
    <div>Accommodation created</div>
    <pre><?php print_r($accommodation); ?></pre>
    <a href='../index.htm'>Back</a>
  </body>
</html>
