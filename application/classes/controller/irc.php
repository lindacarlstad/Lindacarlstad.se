<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Irc extends Templating {
	public function action_index()
	{
		$this->template->content = View::factory('irc/irc_index');
	}
} // End Welcome
