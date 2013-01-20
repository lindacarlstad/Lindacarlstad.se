<?php defined('SYSPATH') or die('No direct script access.');

class Controller_News extends Templating {

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
	
	public function action_create()
	{
		if(Arr::get($_POST, 'submit', FALSE))
		{
			$news = ORM::Factory('news');
			
			$news->title = Arr::get($_POST, 'title');
			$news->text = Arr::get($_POST, 'text');
			$news->user_id = $this->user;
			$news->timestamp = time();
			$news->url = Text::urlify(Arr::get($_POST, 'title').'-'.Text::limit_chars(uniqid(md5(time())), 3, ''));
			
			try{
				$news->check();
				$news->save();
				
				if(Arr::get($_POST, 'tags', FALSE))
				{
					$tags = explode(',', Arr::get($_POST, 'tags', NULL));
					$tagsobject = ORM::Factory('tag')->set_or_get($tags);
					$news->add('tags', $tagsobject);
				}
				
				$this->request->redirect('/news/story/'.$news->url);
				
			}
			catch (ORM_Validation_Exception $e)
        	{
        	    $errors = $e->errors('register');
        	    $values = $_POST;
        	}

		}
	
		$this->template->content = View::factory('news/news_create')
			->bind('values', $values);
		
		$this->assets(array(
			'css' => array('news/news_create', 'autocompleter', 'markdown'),
			'js' => array('classes/mooindent','news/news_create'),
		));
	}
	
	public function action_story($story = NULL){
		
		$story = $this->request->param('id');
		
		$news = ORM::factory('news', array('url' => $story));
		
		if($news)
		{
			if(Arr::get($_POST, 'submit', FALSE))
			{
				$comment = ORM::Factory('comment');
				
				$comment->timestamp = time();
				$comment->user_id = $this->user;
				$comment->comment = arr::get($_POST, 'comment');
				if(Arr::get($_POST, 'replies', FALSE))
				{
					$comment->comments_id = arr::get($_POST, 'replies');
				}
				else
				{
					$comment->news_id = $news;
				}
				
				try{
					$comment->check();
					$comment->save();
					$this->request->redirect('/news/story/'.$story.'/#comments');				
				}
				catch (ORM_Validation_Exception $e)
        		{
        		    $errors = $e->errors('register');
        		    $values = $_POST;
        		}
			}
				
			$this->template->content = View::factory('news/news_story')
				->bind('story', $news)
				->bind('errors', $errors)
				->bind('values', $values);
		}
		else
		{
			$this->template->content = 'Du har gått vilse! ha-haha-haha-ha';
		}
		
		$this->assets(array(
			'css' => array('news/news_story', 'markdown'),
			'js' => array('news/news_story')
		));
	}

} // End Welcome
