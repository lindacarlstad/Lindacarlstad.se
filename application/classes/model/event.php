<?php defined('SYSPATH') or die('No direct script access.');
class Model_Event extends ORM {
	
	protected $_belongs_to = array(
		'type' => array('model' => 'eventtype', 'foreign_key' => 'eventtype_id'),
	);
	
	public function rules(){
		return array(
			'title' => array(
				array('not_empty'),
				array('min_length', array(':value', 3)),
				array('max_length', array(':value', 128)),
			),
			'timestamp' => array(
				array('not_empty'),
				array('numeric'),
			),
			'timestamp_ends' => array(
				array('numeric'),
				array(array($this, 'is_greater_than'), array(':validation', ':field', 'timestamp')),
			),
			'text' => array(),
			'place' => array(			
				array('max_length', array(':value', 128)),
			),
			'eventtype_id' => array(),
		);
	}
	
	
	public static function is_greater_than($validation, $field, $compare){
		return ($validation[$field] > $validation[$compare]);
	}
	
}