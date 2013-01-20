<?php defined('SYSPATH') or die('No direct script access.');
class Model_RecoverToken extends ORM {

	protected $_table_name = 'recover_tokens';
	protected $_primary_key = 'id';
	
	public function before_save()
	{
		$this->timestamp = time();
		
	}
	
	public function make_key(){
		do{
			$key = md5(Text::random());
		}
		while($this->where('key', '=', $key)->count_all() > 0);
		
		return $key;
	
	}
	
	public function save(Validation $validation = NULL)
	{
		parent::save();
	}


}