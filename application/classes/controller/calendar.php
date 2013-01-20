<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Calendar extends Templating {

	/**
	 *	NEW EVENTS
	 */
	public function action_new(){
		
		if(Arr::get($_POST, 'submit', FALSE))
		{
			$event = ORM::factory('event')->values($_POST, array('title', 'text', 'place'));
			
			/*
			 *	FIX TIME & DATE
			 */
			$starts = date_parse(Arr::Get($_POST, 'date').' '.Arr::get($_POST, 'time'));
			$starts = mktime($starts['hour'], $starts['minute'], 0, $starts['month'], $starts['day'], $starts['year']);
			
			$ends = date_parse(Arr::Get($_POST, 'date_end').' '.Arr::get($_POST, 'time_end'));
			$ends = mktime($ends['hour'], $ends['minute'], 0, $ends['month'], $ends['day'], $ends['year']);
			
			
			$event->eventtype_id = Arr::Get($_POST, 'eventtype');
			$event->timestamp = $starts;
			$event->timestamp_ends = $ends;
						
			
			try{
				$event->check();
				$event->save();
			}			
			catch (ORM_Validation_Exception $e)
        	{
        	    $errors = $e->errors('calendar');
        	    $values = $_POST;
        	}
		}
		
		$eventtypes_src = ORM::factory('eventtype')->find_all();
		
		$eventtypes = array();
		
		foreach($eventtypes_src as $type)
		{
			$eventypes[$type->id] = $type->name;
		}
		
		$this->template->content = View::factory('calendar/calendar_new')
			->bind('values', $values)
			->bind('eventtypes', $eventypes)
			->bind('errors', $errors);
		
		$this->assets(array(
			'css' => 'calendar/calendar_new',
			'js' => 'calendar/calendar_new'
		));	
		
	}
	
	public function action_edit()
	{
		$event = ORM::factory('event', $this->request->param('id'));
		
		if($event->loaded() AND $this->user->is_not_a_slave())
		{
			if(Arr::get($_POST, 'submit', FALSE))
			{
				$event->values($_POST, array('name', 'place', 'text'));
				
				/*
				 *	FIX TIME & DATE
				 */
				$starts = date_parse(Arr::Get($_POST, 'date').' '.Arr::get($_POST, 'time'));
				$starts = mktime($starts['hour'], $starts['minute'], 0, $starts['month'], $starts['day'], $starts['year']);
				
				$ends = date_parse(Arr::Get($_POST, 'date_end').' '.Arr::get($_POST, 'time_end'));
				$ends = mktime($ends['hour'], $ends['minute'], 0, $ends['month'], $ends['day'], $ends['year']);
				
				
				$event->eventtype_id = Arr::Get($_POST, 'eventtype');
				$event->timestamp = $starts;
				$event->timestamp_ends = $ends;
						
			
				try{
					$event->check();
					$event->save();
					$this->request->redirect('/calendar/event/'.$event);
				}			
				catch (ORM_Validation_Exception $e)
    	    	{
    	    	    $errors = $e->errors('calendar');
    	    	    $event = $_POST;
    	    	}		
			}
			
			$values = $event->as_array();
			
			$values['date'] = date('Y-m-d', $event->timestamp);
			$values['time'] = date('H:i', $event->timestamp);
			$values['date_end'] = date('Y-m-d', $event->timestamp_ends);
			$values['time_end'] = date('H:i', $event->timestamp_ends);
						
			$eventtypes_src = ORM::factory('eventtype')->find_all();
			
			$eventtypes = array();
			
			foreach($eventtypes_src as $type)
			{
				$eventypes[$type->id] = $type->name;
			}
			
			$this->template->content = View::factory('calendar/calendar_edit')
				->bind('values', $values)
				->bind('eventtypes', $eventypes)
				->bind('errors', $errors);
			
			$this->assets(array(
				'css' => 'calendar/calendar_new',
				'js' => 'calendar/calendar_new'
			));
		}
		else
		{
			throw new HTTP_Exception_404;
		}
	}
	
	public function action_delete()
	{
		$event = ORM::factory('event', $this->request->param('id'));
		
		if($event->loaded() AND $this->user->is_not_a_slave())
		{
			if(Arr::get($_POST, 'submit', FALSE))
			{
				$event->delete();
				$this->request->redirect('/');
			}
			
			$this->template->content = View::factory('calendar/calendar_delete')
				->bind('event', $event);
			
			$this->assets(array(
				'css' => 'calendar/calendar_delete',
				'js' => 'calendar/calendar_delete'
			));
		}
		else
		{
			throw new HTTP_Exception_404;
		}

	}
	
	/**
	 * VIEW EVENT
	 */
	public function action_event(){
	
		$id = $this->request->param('id');
	
		$event = ORM::Factory('event', $id);
		
		if($event->loaded())
		{
			$this->template->content = view::factory('calendar/calendar_event')
				->bind('event', $event);
		}
		else
		{
			$this->template->content = Request::factory()->status(404);
		}
		
		$this->assets(array(
			'css' => array('calendar/calendar_event', 'markdown'),
			'js' => 'calendar/calendar_event',
		));
	}

} // End Welcome
