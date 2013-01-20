<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Settings_Developer extends Admintemplating {

	public function before(){
		$this->subnav = array(
		//	'View users' => '/admin/settings/users/',
		);
		
		$this->assets(array(
			'css' => 'settings/developer/settings_developer_'.$this->request->param('action', 'index'),
			'js' => 'settings/developer/settings_developer_'.$this->request->param('action', 'index'),
		));
		
		return parent::before();
	}

	public function action_index(){	
	
		if(isset($_POST['submit']))
		{

			$settings = ORM::factory('settings', array('name' => 'under_construction'));
			$settings->value = (isset($_POST['under_construction'])) ? 1 : 0;
			$settings->save();

			Cache::instance()->delete('siteconfig');
		}
	
		$settings = ORM::factory('settings')->find_all();
		
		$settings_array = array();
		foreach($settings as $setting){$settings_array[$setting->name] = $setting->value;}
		
		$this->template->content = View::factory('settings/developer/settings_developer_start')
			->set('settings', $settings_array);		
	}
	
}
