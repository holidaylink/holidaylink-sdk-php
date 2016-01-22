<?php

namespace HolidayLink\Api;

/**
 * Class ArticleComment
 * @package HolidayLink\Api
 */
class ArticleComment extends Model {

  static public $fields = [
    'id',
    'user_id',
    'article_id',
    'language',
    'body',
    'created_at',
    'updated_at',
    'updater_id',
  ];

}
