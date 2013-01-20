<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Forum extends Templating {

	public function action_index()
	{
		$forums = ORM::Factory('forum')
			->order_by('timestamp', 'DESC')
			->limit(10)
			->find_all();
	
		$this->template->content = View::factory('forum/forum_index')
			->bind('forums', $forums);
		
		$this->assets(array(
			'css' => array('forum/forum_index', 'autocompleter'),
			'js'  => 'forum/forum_index',
		));
	}
	
	public function action_bytag()
	{
		$tag_list = ORM::factory('tag')->where('name', 'IN', explode('&', $this->request->param('id')))->find_all()->as_array();
		$tags = ORM::factory('tag')->find_all();
		
		
		if(count($tag_list) == 0)
		{
			Throw new HTTP_Exception_404;
		}
		elseif($tag_list !== NULL){
						
			$forums = DB::select('forums.*', array(DB::expr('COUNT(forums_tags.tag_id)'), 'matching_tags'))
				->from('forums_tags')
				->join('forums', 'INNER')
				->on('forums_tags.forum_id', '=', 'forums.id')
				->where('forums_tags.tag_id', 'IN', DB::expr('('.implode(',', $tag_list).')'))
				->group_by('forums_tags.forum_id')
				->having(DB::expr('COUNT(forums_tags.tag_id)'), '=', count($tag_list))
				->order_by('timestamp', 'DESC')
				->limit(10)
				->as_object()
				->execute();
		}
		else
		{
			$forums = ORM::factory('article')->find_all();
		}
			
		$this->template->content = View::factory('forum/forum_bytag')
			->bind('forums', $forums)
			->bind('taglist', $tag_list)
			->bind('tags', $tags);
			
		$this->assets(array(
			'css' => array('forum/forum_index', 'autocompleter'),
			'js'  => 'forum/forum_index',
		));

	}
	
	public function action_add(){
		if (AUTH::Instance()->get_user() == FALSE)
		{
			$this->request->redirect('/forum/error');
		}
		//if(Arr::get($_POST, 'text', FALSE) && Arr::get($_POST, 'title', FALSE))
		if(Arr::get($_POST, 'text', FALSE))
		{
			$forum = ORM::factory('forum');
			$forum->title = Arr::extract($_POST, array('title'));
			$forum->text = Arr::extract($_POST, array('text'));
				
			$forum->user_id = $this->user->id;
			$forum->timestamp = time();	
			
			$forum->save();
			
			if(Arr::get($_POST, 'tags', FALSE))
			{
				$tags = ORM::factory('tag')->set_or_get(explode(',', arr::get($_POST, 'tags')));	
				$forum->add('tags', $tags);
			}			
			
			$this->template->content = Request::factory('requests/feed/')->execute();
			//$this->request->redirect('/forum/');
		}
		else
		{
			//$this->template->content = View::factory('/forum/forum_add');
		}
		
	}
	
	public function action_error()
	{
		$this->template->content = View::factory('/forum/forum_error');
			$errMsg = 'Var god och logga in för att lägga till trådar!';
			$this->template->content = View::factory('/forum/forum_error')
			->bind('errMsg', $errMsg);
	}
	public function action_discuss()
	{
	
		$id = $this->request->param('id');
		
		$forum = ORM::factory('forum', $id);
		
		if($forum->loaded())
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
					$comment->forum_id = $forum;
				}
				
				try{
					$comment->check();
					$comment->save();
					$this->request->redirect('/forum/discuss/'.$id.'/#comments');				
				}
				catch (ORM_Validation_Exception $e)
        		{
        		    $errors = $e->errors('register');
        		    $values = $_POST;
        		}
			}
		
			$this->template->content = View::Factory('forum/forum_discuss')
				->bind('forum', $forum)
				->bind('values', $values)
				->bind('errors', $errors);
				
			$this->assets(array(
				'css' => array('news/news_story', 'markdown'),
				'js' => array('news/news_story')
			));
		}
		else
		{
			throw new HTTP_Exception_404('the requested uri :uri could not be found', array(':uri' => $this->request->uri()));
		}
	}
	
	public function action_edit()
	{
		$id = $this->request->param('id');
		
		$forum = ORM::Factory('forum', $id);
		
		if($forum->loaded() AND $forum->current_user_has_rights())
		{
			if(Arr::get($_POST, 'submit', FALSE))
			{
				$forum->text = Arr::get($_POST, 'text');
				$forum->save();
				
				$this->request->redirect('/forum/discuss/'.$id);
			}
			
			$this->template->content = View::factory('forum/forum_edit')
				->bind('forum', $forum);
				
			$this->assets(array(
				'css' => 'forum/forum_edit',
				'js' => 'forum/forum_edit',
			));
		}
		else
		{
			throw new HTTP_Exception_404('the requested uri :uri could not be found', array(':uri' => $this->request->uri()));
		}

	}
	
	public function action_delete()
	{
		$id = $this->request->param('id');
		
		$forum = ORM::Factory('forum', $id);
		
		if($forum->loaded() AND $forum->current_user_has_rights())
		{
			if(Arr::get($_POST, 'submit', FALSE))
			{
				$forum->delete();
				$this->request->redirect('/forum/');
			}
			
			$this->template->content = View::factory('forum/forum_delete')
				->bind('id', $forum);
				
			$this->assets(array(
				'css' => 'forum/forum_delete',
				'js' => 'forum/forum_delete',
			));
		}
		else
		{
			throw new HTTP_Exception_404;
		}
	}

} // End Welcome
