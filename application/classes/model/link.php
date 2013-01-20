<?php defined('SYSPATH') or die('No direct script access.');
class Model_Link extends ORM {

	public function rules()
	{
		return array(
			'name' => array(
				array('not_empty'),
				array('min_length', array(':value', 2)),
				array('max_length', array(':value', 128)),
			),
			'url' => array(
				array('url'),
				array('max_length', array(':value', 128)),
			),
		);
	}

}