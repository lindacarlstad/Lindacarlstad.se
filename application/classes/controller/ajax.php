<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ajax extends Controller {

	public function before(){
		/*if(!$this->request->is_ajax()){
			echo 'only ajax...';
			die();
		}*/
	}
	
	public function action_tags(){
	
		if($query = Arr::get($_POST, 'query', FALSE))
		{		

			$tag_list = ORM::factory('tag')->where('name', 'LIKE', "$query%")->find_all()->as_array();
			$tags = array();
			foreach($tag_list as $tag)
			{
				$tags[] = $tag->name;
			}
			$tags = json_encode($tags);

			$this->response->headers(array('Content-type' => 'application/json'));
			$this->response->body($tags);
		}
	}
	
	public function action_textinate()
	{
		$this->response->body(Markdown::instance()->transform(Arr::get($_POST, 'text')));

	}
	
	public function action_calendar(){
		
		$month  = $this->request->param('param');
		$year = $this->request->param('param2');
	
		$this->response->body(Request::factory("requests/calendar/index/$month/$year/")->execute());
	}
	
}