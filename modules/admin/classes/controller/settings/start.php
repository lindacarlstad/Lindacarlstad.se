<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Settings_Start extends Admintemplating {

	public function action_index(){		
		$this->template->content = View::factory('settings/settings_start');		
	}
	
}
