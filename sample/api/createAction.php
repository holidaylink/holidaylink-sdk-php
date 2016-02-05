<?php

require __DIR__ . '/../bootstrap.php';

use HolidayLink\Api\Action;

/**
 * Create action using optional code and your API credentials
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
   *  - accommodation_unit_id,
   *  - status,
   *  - visible_from,
   *  - visible_to,
   *  - applicable_from,
   *  - applicable_to,
   *  - amount_value,
   *  - amount_unit,
   */
  $data = [
    'accommodation_unit_id' => 17,
    'status' => Action::STATUS_ACTIVE,
    'visible_from' => '2016-06-15',
    'visible_to' => '2016-06-30',
    'applicable_from' => '2016-06-15',
    'applicable_to' => '2016-06-30',
    'amount_value' => 35.28,
    'amount_unit' => Action::AMOUNT_UNIT_ABSOLUTE,
  ];

  $action = Action::createSingle($params, $data, $apiCredentials);
} catch (Exception $ex) {
  echo 'Exception:', $ex->getMessage(), PHP_EOL;
  exit(1);
}
?>

<html>
  <head>
    <meta charset="utf-8">
    <title>Action create</title>
  </head>
  <body>
    <div>Action created</div>
    <pre><?php print_r($action); ?></pre>
    <a href='../index.htm'>Back</a>
  </body>
</html>
