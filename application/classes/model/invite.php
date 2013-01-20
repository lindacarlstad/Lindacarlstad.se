<?php defined('SYSPATH') or die('No direct script access.');
class Model_Invite extends ORM {

	protected $_table_name = 'user_invites';
	protected $_primary_key = 'key';

	public function rules()
	{
		return array(
			'email' => array(
				array('not_empty'),
				array('max_length', array(':value', 128)),
				array(array($this, 'email_available'), array(':validation', ':field')),
			),
			
		);
	}
	
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
	
	public function email_available(Validation $validation, $field)
	{		
		if ($this->unique_email_exists($validation[$field]))
		{
			$validation->error($field, 'email_available', array($validation[$field]));
		}
	}
	
	public function unique_email_exists($value)
	{
		$users = DB::select(array('COUNT("*")', 'total_results'))
			->from('users')
			->where('email', '=', $value)
			->execute($this->_db)
			->get('total_results');
		
		$confirmations = DB::select(array('COUNT("*")', 'total_results'))
			->from('user_invites')
			->where('email', '=', $value)
			->execute($this->_db)
			->get('total_results');
			
		$result = $users+$confirmations;
						
		return (bool) $result;
	}
	
	public function save(Validation $validation = NULL)
	{
		parent::save();
	}


}