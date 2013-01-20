<?php defined('SYSPATH') or die('No direct script access.');
class Model_Comment extends ORM {
	
	protected $_has_many = array(
		'comments' => array('model' => 'comment', 'far_key' => 'id', 'foreign_key' => 'comments_id'),
	);
	
	protected $_belongs_to = array(
		'story' => array(),
		'user' => array('model' => 'user', 'foreign_key' => 'user_id', 'far_key' => 'id'),
	);
	
	public function rules(){
		return array(
			'comment' => array(
				array('not_empty'),
			),
		);
	}

}