<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Dev extends Controller {

	public function action_clean()
	{		
		$css = 0;
		$js = 0;
		
		foreach(glob('media/css/*.css') as $file){
    		unlink($file);
    		$css++;
		}
		
		foreach(glob('media/js/*.js') as $file){
    		unlink($file);
    		$js++;
		}
		
		$this->response->body($css.' .css & '.$js.' .javascript files removed');

	}
	
	public function action_email()
	{
		$this->response->body(View::factory('email'));
	}
}