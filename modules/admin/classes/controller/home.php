<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Home extends Admintemplating {

	public function before(){	
		$this->set_subnav(array(
			'Home'		=> '/admin/',
			'Overview' 	=> '/admin/home/overview/',
			'News' 		=> '/admin/home/news/',
			'Changelog'	=> '/admin/home/changelog/',
		));
	
		return parent::before();
	}

	public function action_index(){		
		$this->template->content = View::factory('home');		
	}
	
	public function action_news(){
		$this->template->content = View::factory('home');
	}
	
	public function action_changelog(){
		$this->template->content = View::factory('changelog');
	}
	
	public function action_logout(){
		$this->auth->logout();
		$this->request->redirect('/admin/');
	}

} // End Welcome
