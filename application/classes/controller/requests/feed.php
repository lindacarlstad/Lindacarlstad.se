<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Requests_Feed extends Controller {

	public function action_index(){
		
		$news = DB::select_array(array(
			'news.timestamp',
			'news.user_id',
			'news.text',
			'news.id',
			'news.title',
			'news.url',
			array(DB::expr('news.timestamp+'.(60*60*24*5)), 'priority'),
			))
			->from('news')			
			->order_by('priority', 'DESC')
			->group_by('timestamp')
			->limit(25);
		
		$stories = DB::select_array(array(
			'forums.timestamp',
			'forums.user_id',
			'forums.text',
			'forums.id',
			'forums.title',
			'forums.url',
			array('forums.timestamp', 'priority'),
			))
			->union($news, TRUE)
			->from('forums')
			->as_object()
			->execute();
			
		$body = '';
			
		foreach($stories as $story){
		
			if(!empty($story->title)){
				$story = ORM::Factory('news', array('id' => $story->id));
				$body .= View::factory('requests/feed/posts/news')
					->bind('story', $story);
			}
			else {
				if(Auth::Instance()->get_user())
				{
					$story = ORM::Factory('forum', array('id' => $story->id));
					$body .= View::factory('requests/feed/posts/forums')
						->bind('story', $story);
				}
			}

		}
			
		$this->response->body($body);
	}
	
	public function action_news(){
		$stories = ORM::Factory('news')->order_by('timestamp', 'DESC')->find_all();
		
		$body = '';
			
		foreach($stories as $story){		
			$story = ORM::Factory('news', array('id' => $story->id));
			$body .= View::factory('requests/feed/posts/news')
				->bind('story', $story);
		}
			
		$this->response->body($body);
	}
	
	public function action_forums()
	{
		$forums = ORM::Factory('forum')->order_by('timestamp', 'DESC')->limit(25)->find_all();
		
		$body = '';
			
		foreach($forums as $forum){		
			$story = ORM::Factory('forum', array('id' => $forum->id));
			$body .= View::factory('requests/feed/posts/forums')
				->bind('story', $story);
		}
			
		$this->response->body($body);

	}

}