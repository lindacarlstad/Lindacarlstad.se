<?php defined('SYSPATH') or die('No direct script access.');

class Controller_About extends Templating {

	public function action_index(){
		
		$about = DB::select('text')
			->from('about')
			->where('id', '=', 1)
			->as_object()
			->limit(1)
			->execute()
			->current();
		
		$this->template->content = View::factory('about/about_index')
			->bind('about', $about);
		
		$this->assets(array(
			'css' => array('about/about_index', 'markdown'),
		));
	}

}