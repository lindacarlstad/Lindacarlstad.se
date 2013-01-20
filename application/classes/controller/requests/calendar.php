<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Requests_Calendar extends Controller {

	public function action_index($month = NULL, $year = NULL)
	{
	
		$month = $this->request->param('id');
		$year = $this->request->param('id2');
			
		$calendar = new Calendar(Arr::get($_GET, 'month', date('m')), Arr::get($_GET, 'year', date('Y')));	
		
			$encrypt = Encrypt::Instance('standard');				
			$month = ($month == NULL) ? date('m') : $month;
			$year = ($year == NULL) ? date('Y') : $year;	
			$calendar = new Calendar($month, $year);
			$calendar->attach(
				$calendar->event()
					->condition('timestamp', time())
					->add_class('today')
			)
			->attach(
				$calendar->event()
					->condition('current', FALSE)
					->add_class('padding')
			);
			
			$events = ORM::Factory('event')
				->and_where_open()
					->and_where('timestamp', '>', mktime(0,0,0,$month,0,$year))
					->and_where('timestamp', '<', mktime(0,0,0,$month+2,0,$year))
				->and_where_close()
				->order_by('timestamp', 'DESC')
				->find_all();
			
						
			foreach($events as $event)
			{			
				$output = '<a href="/calendar/event/'.$event->id.'/" data-time="'.strftime("%A %e %B %R", $event->timestamp).'" data-id="'.$event->id.'" title="'.$event->title.'" data-place="'.$event->place.'" class="'.$event->type->class.'"></a>';				
			
				$calendar->attach(
					$calendar->event()
						->condition('timestamp', $event->timestamp)
						->output($output)
				);
			}

			
		$this->response->body($calendar);
	}
	
	public function action_list()
	{
		$events = ORM::factory('event')
			->where_open()
				->where('timestamp', '>', time())
				->where('timestamp', '<', time()+3600*24*60)
			->where_close()
			->limit(10)
			->order_by('timestamp')
			->find_all();
			
		$current_events = ORM::Factory('event')
			->where('timestamp', '<', time())
			->and_where_open()				
				->and_where('timestamp_ends', '>', time())
			->and_where_close()
			->order_by('timestamp')
			->find_all();
	
		$this->response->body(View::factory('requests/calendar/calendar_list')
			->bind('events', $events)
			->bind('current_events', $current_events));
	}

}