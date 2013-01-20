<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Manage extends Admintemplating {
	
	public function action_index()
	{
		$structure = $this->action_structure();
		$this->template->content = View::factory('manage/manage_start')
			->bind('structure', $structure);
			
		$this->assets(array(
			'css' => 'manage/manage_start',
		));
	}
	
	protected function action_structure(){
		return array(
			'Magasin' => array(
				'Artiklar' 			=> 'magazine/',
				'Ny artikel' 		=> 'magazine/new/',				
				'Nyheter i korthet'	=> 'magazine/shortnews/',
			),
			'Klubb'	=> array(				
				'Events' 			=> 'club/',
				'Nytt event' 		=> 'club/new/',
				
			),
			'Samtalet' => array(
				'Samtal'			=> 'conversation/',
				'Nytt samtal'		=> 'conversation/new/',
			),
			'Kalender' => array(
				'Händelser'			=> 'calendar/',
				'Ny händelse'		=> 'calendar/new/',
			),
		);
	}

}
