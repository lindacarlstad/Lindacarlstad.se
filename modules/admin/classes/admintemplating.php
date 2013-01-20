<?php defined('SYSPATH') or die('No direct script access.');

class Admintemplating extends Kohana_Admintemplator {

	public function before(){
		
		$this->assets(array('css' => array('_vars','_functions','globalMaster','globalStyle','globalLayout')));
		$this->assets(array('js' => 'globalCode'));
		
		return parent::before();
	}

	public function after(){
		
		return parent::after();
	}

}