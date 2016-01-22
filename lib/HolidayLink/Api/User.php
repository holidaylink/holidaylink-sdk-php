<?php

namespace HolidayLink\Api;

/**
 * Class User
 * @package HolidayLink\Api
 */
class User extends Model {

  static public $fields = [
    'code',
    'first_name',
    'last_name',
    'company',
    'vat_number',
    'responsible_person',
    'photo',
    'mobilePhone',
    'contactPhones',
    'booking_inquiry_email',
    'contact_email',
    'cooperation_mode',
    'provision_payment_type',
    'country',
    'city',
    'post_code',
    'address',
    'user_comment',
  ];

}
