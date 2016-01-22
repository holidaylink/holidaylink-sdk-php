<?php

namespace HolidayLink\Api;

/**
 * Class ArticleLang
 * @package HolidayLink\Api
 */
class ArticleLang extends Model {

  static public $fields = [
    'id',
    'article_id',
    'language',
    'body',
    'translate_method',
    'created_at',
    'updated_at',
    'creator_id',
    'update_id',
  ];

}
