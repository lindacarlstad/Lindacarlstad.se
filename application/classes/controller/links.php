<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Links extends Templating {

	public function action_index(){
	
		if(Arr::get($_POST, 'submit', FALSE))
		{
			$links = ORM::Factory('link')->values($_POST, array('name', 'url', 'text', 'linkcat_id'));
			
			try{
				$links->check();
				$links->save();
			}
			catch(ORM_Validation_Exception $e)
			{
				$errors = $e->errors();
				$values = $_POST;
			}
		}
				
		$links = DB::select_array(array('links.*', array('linkcat.name', 'category')))
			->from('linkcat')
			->join('links', 'INNER')
			->on('linkcat.id', '=', 'links.linkcat_id')
			->order_by('linkcat.name', 'ASC')
			->order_by('links.name', 'ASC')
			->as_object()
			->execute();
		
		$linktypes_obj = ORM::factory('linkcat')->find_all();
		$linktypes = array();
		
		foreach($linktypes_obj as $link)
		{
			$linktypes[$link->id] = $link->name;	
		}
		
		$this->template->content = View::factory('links/links_index')
			->bind('links', $links)
			->bind('linktypes', $linktypes)
			->bind('values', $values)
			->bind('errors', $errors);
		
		$this->assets(array(
			'css' => array('links/links_index'),
			'js' => array('links/links_index')
		));
	}
}