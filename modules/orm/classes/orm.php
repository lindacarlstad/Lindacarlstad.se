<?php defined('SYSPATH') or die('No direct script access.');

class ORM extends Kohana_ORM {

	public function before_save()
	{
		
	}
	
	public function save(Validation $validation = NULL)
	{
		$this->before_save();
		
		parent::save();
	}

}
