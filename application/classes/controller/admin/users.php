<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Users extends Templating {

	public function before()
	{
		if(!AUTH::Instance()->get_user()->has('roles', ORM::factory('role', array('name' => 'admin'))))
		{
			$this->request->redirect('/');
		}
		
		return parent::before();
	}

	public function action_index()
	{	
		$users = ORM::Factory('user')->order_by('surname', 'ASC')->find_all();
		
		$this->template->content = View::factory('admin/users/users_index')
			->bind('users', $users);
		
		$this->assets(array(
			'css' => array('admin/admin_index', 'admin/users/users_nav', 'admin/users/users_index'),
		));
	}
	
	public function action_invite(){
	
		if(Arr::get($_POST, 'submit', FALSE))
		{
			foreach(Arr::get($_POST, 'email', FALSE) as $email)
			{
				if(isset($email) AND $email)
				{
					$invite = ORM::Factory('invite');
					$invite->email = $email;
					try{
						$invite->check();
						
						$invite->key = $invite->make_key();
						
						Email::factory('Välkommen till LINDA Carlstad', View::factory('email/invite')->set('key', $invite->key), 'text/html')
							->to($email)
							->from('invite@lindacarlstad.se', 'LINDA Carlstad')
							->send();
						
						$invite->save();
					}
					catch (ORM_Validation_Exception $e)
        			{
        			    $errors[] = $e->errors('invite');
        			    $values[] = $email;
        			}
        		}
			}

		}
		
		$this->template->content = View::factory('admin/users/users_invite')
			->bind('values', $values)
			->bind('errors', $errors);
		
		$this->assets(array(
			'css' => array('admin/admin_index', 'admin/users/users_nav', 'admin/users/users_invite'),
			'js' => 'admin/users/users_invite',
		));
	}
}