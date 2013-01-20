<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Requests_Usersection extends Controller {

	public function action_login()
	{		
		$this->response->body(View::Factory('requests/usersection/login'));
	}
	
	public function action_usersection()
	{
		$this->response->body(View::factory('requests/usersection/usersection'));
	}
	
	public function action_lastlogged()
	{
		$users = ORM::Factory('user')
			->limit(5)
			->order_by('last_login', 'DESC')->find_all();
	
		$this->response->body(View::factory('requests/usersection/lastlogged')
			->bind('users', $users));
	}
}