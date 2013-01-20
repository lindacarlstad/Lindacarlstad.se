<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Start extends Templating {

	public function action_index()
	{
		$this->template->content = View::factory('index');
		
		$this->assets(array(
			'css' => array('index/index_index', 'autocompleter', 'markdown'),
			'js'  => 'index/index.js',
		));
	}
/*
	public function action_index()
	{
		$news = ORM::Factory('news')->order_by('timestamp', 'DESC')->limit(5)->find_all();
		
		$this->template->content = View::factory('news/news_index')
			->bind('news', $news);
		
		$this->assets(array(
			'css' => array('news/news_index', 'markdown'),
			'js'  => 'news/news_index',
		));
	}
 * 
*/
} // End Welcome
