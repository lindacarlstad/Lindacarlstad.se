<?php defined('SYSPATH') or die('No direct script access.');

class Kohana_Templator extends Controller_Template 
{

	public $settings;
	public $template;
	public $subnav = array();
	public $assets = array('css'=>array(),'js'=>array());
	public $user;
	
	private $loginstatus = NULL;
	private $uri;
	
	public function before()
	{
		$this->auth = AUTH::instance();
		$this->settings = Kohana::$config->load('siteconfig');		
		$this->template = $this->settings->template;
		$this->uri = $this->request->uri();		
		
		
		/**
		 *	Looks for loginattempts
		 */		 
		
		if(!$this->auth->get_user() AND !$this->auth->auto_login() AND isset($_POST['login']))
		{
			$this->loginstatus = $this->auth->login(Arr::get($_POST, 'email', NULL), Arr::get($_POST, 'password', NULL), (Arr::get($_POST, 'remember')) ? TRUE : FALSE);
		}
		
		
		
		$this->user = $this->auth->get_user();
		return parent::before();
	}

	public function after()
	{			
		$this->template->set_global('user', $this->auth->get_user());	
		$this->template->set_global('siteconfig', $this->settings);
		$this->template->set('assets', $this->assets);
		$this->template->set('subnav', $this->subnav);		
		/*
		$this->template->set('uri', URL::linkToUri($this->uri));
		$this->template->set('controller', URL::controller($this->uri));
		*/
				
		if(!$this->auth->logged_in())
		{
			
			if(isset($this->loginstatus))
			{
				$this->template->set_global('loginerrors', $this->loginstatus);
			}
			/*
			$this->auto_render = false;
			$this->addfile('css', 'login');
			echo View::factory('login')
				->set('siteconfig', $this->settings)
				->set('assets', $this->assets)
				->set('errors', $loginstatus);
			*/
		}		

		
		if($this->request->is_ajax())
		{
			$this->auto_render = false;
			$this->response->body($this->template->content);
		}
		
		/**
		 *	Show under construction page if the site is set to under_construction
		 */
		if($this->settings->under_construction)
		{
			$this->auto_render = false;
			$this->response->body(View::factory('under_construction'));
		}
		
		return parent::after();
	}
	
	
	//Adding assets like CSS & Javascript to the template
	
	public function addfile($key, $file)
	{
		$this->assets[$key][] = $file;
	}
	
	public function assets($assets)
	{
		if(is_array($assets))
		{
			foreach($assets as $key => $asset)
			{
				if(is_array($asset))
				{
					foreach($asset as $a)
					{
						$this->addfile($key, $a);
					}
				}
				else
				{
					$this->addfile($key, $asset);
				}
			}
		}
		else
		{
			return FALSE;
		}
	}
	
	public function set_subnav($array)
	{
		$this->subnav = Arr::merge($this->subnav, $array);
	}

}
