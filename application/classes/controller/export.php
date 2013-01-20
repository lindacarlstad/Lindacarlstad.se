<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Export extends Controller {

	public function action_calendar()
	{
		$events = ORM::factory('event')->find_all();
		
		$ics = ICS::factory();
		
		foreach($events as $event)
		{			
			$ics_event = ICS_Event::factory()->set(array(
				'summary' => $event->title,
				'dtstart' => $event->timestamp,
				'dtend' => $event->timestamp_ends,
				'location' => $event->place,
				'description' => $event->text,
			));	
			
			$ics->add($ics_event);
				
		}
		
				
		$this->response->headers('Content-type', 'text/calendar');
		
		$this->response->body($ics->execute());
	}
}