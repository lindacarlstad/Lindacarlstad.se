<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Settings_Users extends Admintemplating {

	public function before(){
		$this->subnav = array(
			'View users' => '/admin/settings/users/',
			'Create user' => '/admin/settings/users/create/',
			'User roles' => '/admin/settings/users/roles/',
		);
		
		$this->assets(array(
			'css' => 'settings/users/settings_users_'.$this->request->param('action', 'index'),
			'js' => 'settings/users/settings_users_'.$this->request->param('action', 'index'),
		));
		
		return parent::before();
	}

	public function action_index(){	
	
		$users = ORM::factory('user')->order_by('surname', 'ASC')->order_by('name', 'ASC')->find_all();
		
		$this->template->content = View::factory('settings/users/settings_users_start')
			->set('users', $users);		
	}
	
	public function action_create(){
	
		$this->template->content = View::factory('settings/users/settings_users_create')
			->bind('values', $values)
			->bind('errors', $errors);
		
		if(isset($_POST['submit'])){
			$_POST['password'] = Text::random();
			$values = $_POST;
			$user = ORM::Factory('user')
				->values($_POST, array('name', 'surname', 'username', 'email', 'password'));
			
			try{
				$user->check();
				$user->save();   
            	$user->add('roles', array_values(Arr::get($_POST, 'roles')));
				$this->request->redirect('/admin/settings/users/');
        	}
        	catch (ORM_Validation_Exception $e){
        	    $errors = $e->errors('models');
        	}			
		}
	}
	
	public function action_edit($username = null){
		$user = ORM::Factory('user', array('username' => $username));
		
		$user_as_array = $user->as_array();
		
		if(!$user->loaded()){$this->request->redirect('/admin/settings/users/');}
		
		$this->template->content = View::factory('settings/users/settings_users_edit')
			->bind('values', $user_as_array)
			->bind('user', $user)
			->bind('errors', $errors);
			
		if(isset($_POST['submit'])){
			$user->values($_POST, array('name', 'surname', 'username', 'email', 'password', 'confirm_password'));
			if(isset($_FILES['image']))
			{
				$user->image = $user->image;
			}			
			
			try{
				$user->check();
				$user->save();
				$user->new_roles(Arr::get($_POST, 'roles'));
            	//$user->add('roles', array_values(Arr::get($_POST, 'roles')));
				$this->request->redirect('/admin/settings/users/');
        	}
        	catch (ORM_Validation_Exception $e){
        	    $errors = $e->errors('models');
        	}			
		}
	}
	
	public function action_roles(){
		$roles = ORM::factory('role')->find_all();
		
		$this->template->content = View::factory('settings/users/settings_users_roles')
			->set('roles', $roles);
	}
}
