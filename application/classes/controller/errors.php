<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Errors extends controller {

	public function action_404()
	{
		$this->response->body(View::factory('errors/404'));
		
	}
	
	public function action_403()
	{
		$this->response->body(View::factory('errors/403'));
		
	}
	
	public function action_500()
	{
		$this->response->body(View::factory('errors/500'));
		
	}

} // End Welcome
