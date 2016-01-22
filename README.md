# Holiday-Link.com API SDK for PHP

This repository contains Holiday-Link.com PHP SDK and samples for our API

## Prerequisites

   * PHP 5.3 or above
   * curl extension must be enabled
   * json extension must be enabled
   * composer for fetching dependencies (See http://getcomposer.org)

## Samples

   * [Running the samples](sample/)

## Usage

To write an app that uses the SDK

   * add `holidalink/api-sdk-php` to your `composer.json` require list or copy the [sample/composer.json]
   (sample/composer.json) to your project's root
   * run `composer update` to fetch dependencies
   * obtain API credentials from [Holiday-Link.com](http://www.holiday-link.com/)
   * now you are all set to make your first API call

```php
$apiCredentials = new \HolidayLink\Auth\Credentials($config['access-token]);

try {
    $params = array(
      'expand' => 'field1, field2, field3',
    );
    $entity = Entity::allFromXML($params, $apiCredentials);
} catch (Exception $ex) {
    echo 'Exception:', $ex->getMessage(), PHP_EOL;
    exit(1);
}

print_r($entity->toArray());
```
