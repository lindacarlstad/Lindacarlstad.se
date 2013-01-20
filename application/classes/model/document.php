<?php defined('SYSPATH') or die('No direct script access.');
class Model_Document extends ORM {
	
	public function rules(){
		return array(
			'name' => array(
				array('not_empty'),
				array('min_length', array(':value', 5)),
				array('max_length', array(':value', 64)),
			),
		);
	}
	
	public function save_file($file)
	{
		$validation = Validation::factory($file);
		//$validation->rule('file', array('Upload::not_empty'));
		//$validation->rule('file', array('Upload::valid'));
			
		if($validation->check())
		{
			$filename = md5(time());
			
			while(is_file('files/'.$filename))
			{
				$filename = md5(Text::random().time());
			}
			
			$upload = Upload::save($validation['file'], $filename.'.store', 'files/');
			
			$this->file = $filename.'.store';
			$this->extension = strtolower(pathinfo($file['file']['name'], PATHINFO_EXTENSION));
		}
	}
	
	public function delete_with_file()
	{
		unlink('files/'.$this->file);
		return $this->delete();
	}
	
	public function before_save()
	{	
		$this->timestamp = time();
		$this->url = Text::urlify($this->name.'-'.Text::limit_chars(uniqid(md5(time())), 3, ''));
	}

}