<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Documents extends Templating {

	public function action_index(){
		
		if(Arr::get($_POST, 'submit', FALSE))
		{
			$document = ORM::factory('document')->values($_POST, array('name'));
			
			try{
				$document->check();
				$document->save_file($_FILES);
				$document->save();
			}
			catch(ORM_Validation_Exception $e)
			{
				$errors = $e->errors();
				$values = $_POST;
			}
		}
		
		$documents = ORM::factory('document')
			->order_by('timestamp', 'DESC')
			->find_all();
		
		$this->template->content = View::factory('documents/documents_index')
			->bind('documents', $documents)
			->bind('errors', $errors)
			->bind('values', $values);
		
		$this->assets(array(
			'css' => array('documents/documents_index'),
			'js' => array('documents/documents_index')
		));
	}
	
	public function action_download()
	{
		$file = $this->request->param('id');
	
		$document = ORM::factory('document', array('url' => $file));
				
		if($document->loaded() AND $this->user)
		{
			$this->response->send_file('files/'.$document->file, $document->name.'.'.$document->extension);
		}
		else{
			Throw new HTTP_Exception_404('invalid file');
		}
	}
	
	public function action_delete()
	{
		$document = ORM::factory('document', array('url' => $this->request->param('id')));
		
		if($document->loaded() AND $this->user->is_not_a_slave())
		{
			$document->delete_with_file();
			$this->request->redirect('/documents/');
		}
		else
		{
			throw new HTTP_Exception_404;
		}
	}

}