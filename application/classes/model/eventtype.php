<?php defined('SYSPATH') or die('No direct script access.');
class Model_Eventtype extends ORM {
	
	protected $_has_many = array(
		'events' => array('far_key' => 'eventtype_id', 'foreign_key' => 'id'),
	);

}