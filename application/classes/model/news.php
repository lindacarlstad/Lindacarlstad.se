<?php defined('SYSPATH') or die('No direct script access.');
class Model_News extends ORM {

	protected $_has_many = array(
		'tags' => array('through' => 'news_tags'),
		'comments' => array('model' => 'comment', 'far_key' => 'news_id'),
	);
	
	protected $_belongs_to = array(
		'user' => array(),
	);

}