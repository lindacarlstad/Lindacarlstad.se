<?php defined('SYSPATH') or die('No direct script access.');

class Templating extends Kohana_Templator {

	public function before()
	{		
		$this->assets(array('css' => array('_vars','_functions','globalMaster','globalStyle','globalLayout','calendar')));
		$this->assets(array('js' => 'globalCode'));
		
		return parent::before();
	}

	public function after()
	{		
		return parent::after();
	}

}