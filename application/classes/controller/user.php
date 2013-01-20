<?php defined('SYSPATH') or die('No direct script access.');

class Controller_User extends Templating {

	public function action_index()
	{	
		if(!$this->request->param('id') AND !$this->user)
		{
			throw new HTTP_Exception_404('the current uri :uri could not be found', array(':uri', $this->request->uri()));
		}

		$user = ORM::factory('user', ($this->request->param('id')) ? $this->request->param('id') : $this->user);
		
		if(!$user->loaded())
		{
			throw new HTTP_Exception_404('user with id :id was not found', array(':id' => $this->request->param('id')));
		}
	
		$roles_src = $user->roles->where('name', '!=', 'login')->find_all();
		
		$roles = array();
		
		foreach($roles_src as $role){
			$roles[] = $role->name;
		}
	
		$this->template->content = View::factory('user/user_profile')
			->bind('user', $user)
			->bind('roles', $roles);
			
		$this->assets(array(
			'css' => 'user/user_profile',
			'js' => 'user/user_profile'
		));
	}
	
	public function action_profile()
	{
		$user = ORM::Factory('user', $this->request->param('id'));
		
		if(!$user->loaded())
		{
			throw new HTTP_Exception_404('profile with id :id was not found', array(':id' => $this->request->param('id')));
		}
		
		$roles_src = $user->roles->where('name', '!=', 'login')->find_all();
		
		$roles = array();
		
		foreach($roles_src as $role){
			$roles[] = $role->name;
		}
		
		$this->template->content = View::factory('user/user_profile')
			->bind('user', $user)
			->bind('roles', $roles);
			
		$this->assets(array(
			'css' => 'user/user_profile',
			'js' => 'user/user_profile'
		));
	}
	
	public function action_settings()
	{
		$user = ORM::Factory('user', $this->user);
		
		if(isset($_POST['submit']))
		{			
			
			$user->city = Arr::get($_POST, 'city', NULL);
			$user->occupation = Arr::get($_POST, 'occupation', NULL);
			$user->birthday = mktime(0, 0, 0, Arr::get($_POST, 'birthday_month'), Arr::get($_POST, 'birthday_day'), Arr::get($_POST, 'birthday_year'));	
									
			if(Upload::not_empty(Arr::get($_FILES, 'image', FALSE)))
			{
				$array = Validation::factory($_FILES);				
				$array->rule('image', 'Upload::type', array(':value', array('jpg', 'png', 'gif')));
				
				if($array->check())
				{
					$image_base = Upload::save(Arr::get($_FILES, 'image'));
					
					$image = Image::factory($image_base);
					
					$name = $user->id.'U'.uniqid();
					
					$image->resize(69, 69, Image::INVERSE)
						->crop(69, 69)
						->save('images/users/'.$name.'.jpg');
						
					unlink($image_base);
					
					$user->image = $name;
				}
				
			}
			
			if(Arr::get($_POST, 'password', FALSE) AND $this->auth->hash_password(Arr::get($_POST, 'oldpassword')) == $user->password)
			{
				$user->password = Arr::get($_POST, 'password');
			}	
						
			try{
				$user->check();
				$user->save();
			}
			catch (ORM_Validation_Exception $e)
        	{
        	    $errors = $e->errors('register');
        	    $values = $_POST;
        	}
		}
		
		$options = array();
		
		foreach(range(date("Y")-17, 1960) as $number){
			$options['year'][$number] = $number;
		}
		
		foreach(range(1, 12) as $number){
			$options['month'][$number] = $number;
		}
		
		foreach(range(1, 31) as $number){
			$options['day'][$number] = $number;
		}
		
		$user = ORM::Factory('user', $this->user);
		
		$this->template->content = View::factory('user/user_settings')
			->bind('errors', $values)
			->bind('options', $options)
			->bind('user', $user);
			
		$this->assets(array(
			'css' => 'user/user_settings',
			'js' => 'user/user_settings',
		));
	}
	
	public function action_inbox()
	{
		$this->template->content = View::factory('user/user_inbox');
	}
}