<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Admin extends Templating {

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
		$this->template->content = View::factory('admin/admin_index');
		
		$this->assets(array(
			'css' => 'admin/admin_index',
		));
	}
}