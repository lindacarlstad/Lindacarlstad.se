<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Requests_Twitter extends Controller {

	public function action_index()
	{
		$cache = Cache::instance();
	
		$feed = $cache->get('twitter-feed');
	
		if(!$feed)
		{
			$settings = Kohana::$config->load('oauth.twitter');  
		    
		   	$consumer = OAuth_Consumer::factory($settings);
	
	      	$access_token = OAuth_Token::factory('access', $settings['token']);
		      
			$twitter = Twitter::factory('status');
		   
		   	$feed = $twitter->user_timeline($consumer, $access_token, array('count' => 8));
		   	
		   	$cache->set('twitter-feed', $feed, 60*2);
		 }
		
		$this->response->body(View::factory('requests/twitter/twitter_index')
			->bind('feed', $feed));
	}

}