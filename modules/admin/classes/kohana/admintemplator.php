<?php defined('SYSPATH') or die('No direct script access.');
/*
 * Mintcore extended template controller for handling the
 * config files aswell as mediafiles such as CSS & Javascript
 */


class Kohana_Admintemplator extends Controller_Template {

	public $settings;
	public $template;
	public $subnav = array();
	public $assets = array('css'=>array(),'js'=>array());
	private $uri;
	
	public function before(){
		$this->auth = AUTH::instance();
		$this->settings = Kohana::$config->load('admin');		
		$this->template = $this->settings->template;
		$this->uri = $this->request->uri();
		
		if(isset($_POST['login'])){
			$loginstatus = $this->auth->login(Arr::get($_POST, 'username'), Arr::get($_POST, 'password'), true);
		}
		
		$this->user = $this->auth->get_user();
				
		return parent::before();
	}

	public function after(){		
	
		if(!$this->auth->logged_in()){
			
			if(!isset($loginstatus)){$loginstatus = false;}
			
			$this->auto_render = false;
			$this->addfile('css', 'login');
			$this->response->body(View::factory('login')
				->set('siteconfig', $this->settings)
				->set('assets', $this->assets)
				->set('errors', $loginstatus));
		}
	
		$this->template->set_global('siteconfig', $this->settings);
		$this->template->set_global('user', $this->user);
		$this->template->set('assets', $this->assets);
		$this->template->set('subnav', $this->subnav);		
		$this->template->set('uri', URL::linkToUri($this->uri));
		$this->template->set('controller', URL::controller($this->uri));
		
		if($this->request->is_ajax()){
			$this->auto_render = false;
			$this->response->body($this->template->content);
		}
		
		return parent::after();
	}
	
	
	//Adding assets like CSS & Javascript to the template
	
	public function addfile($key, $file){
		$this->assets[$key][] = $file;
	}
	
	public function assets($assets){
		if(is_array($assets)){
			foreach($assets as $key => $asset){
				if(is_array($asset)){
					foreach($asset as $a){
						$this->addfile($key, $a);
					}
				}
				else{
					$this->addfile($key, $asset);
				}
			}
		}
		else{return FALSE;}
	}
	
	public function set_subnav($array){
		$this->subnav = Arr::merge($this->subnav, $array);
	}

}
