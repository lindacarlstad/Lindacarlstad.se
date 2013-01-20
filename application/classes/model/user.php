<?php defined('SYSPATH') or die('No direct access allowed.');

class Model_User extends Model_Auth_User {

	protected $_has_many = array(
		'user_tokens'	=> array('model' => 'user_token'),
		'roles'      	=> array('model' => 'role', 'through' => 'roles_users'),
		'comments'		=> array('model' => 'comment', 'far_key' => 'user_id', 'foreign_key' => 'id'),
	);
	
	/**
	 * Filters to run when data is set in this model. The password filter
	 * automatically hashes the password when it's set in the model.
	 *
	 * @return array Filters
	 */
	public function filters()
	{
		return array(
			'password' => array(
				array(array(Auth::instance(), 'hash'))
			),
			'email' => array(
				array('strtolower')
			),
			'name' => array(
				array('ucfirst'),
			),
			'surname' => array(
				array('ucfirst'),
			),
		);
	}


	public function new_roles($roles = array())
	{
		if(!count($roles) > 0)
		{
			$this->remove('roles');
			return $this;
		}
	
		$user_roles = $this->roles->find_all();
		foreach($user_roles as $role)
		{
			if(!in_array($role, $roles))
			{
				$this->remove('roles', $role);
			}
		}
		
		$new_roles = array();
		
		foreach($roles as $role)
		{
			if(!$this->has('roles', $role))
			{
				array_push($new_roles, $role);
			}
		}
		
		if(count($new_roles) > 0)
		{
			$this->add('roles', array_values($new_roles));
		}
		
		return $this;
	}
	
	public function before_save()
	{
		if(!$this->joined)
		{
			$this->joined = time();
		}
	}
	
	public function link_to()
	{
		return HTML::anchor('');
	}
	
	public function full_name()
	{
		return $this->name.' '.$this->surname;
	}
	
	public function is_admin()
	{
		return $this->has('roles', $this->roles->where('name', '=', 'admin')->find());
	}
	
	/**
	 *	If the current user has higher privileges than regular users	
	 */
	public function is_not_a_slave()
	{
		return $this->has('roles', $this->roles->where('id', '>', 1)->find());
	}

}