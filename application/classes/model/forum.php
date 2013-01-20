<?php defined('SYSPATH') or die('No direct script access.');
class Model_Forum extends ORM {

	protected $_has_many = array(
		'tags' => array('through' => 'forums_tags'),
		'comments' => array('foreign_key', 'forums_id', 'far_key' => 'forums_id'),
	);
	
	protected $_belongs_to = array(
		'user' => array(),
	);	
		
	/**
	 *	If the current user has rights to edit or delete this post
	 */
	public function current_user_has_rights()
	{
		return ($this->user_id == AUTH::Instance()->get_user() OR $this->is_not_a_slave());
	}

}