<?php defined("SYSPATH") or die("No direct script access.");

class Ics_Event {
	
	public $summary; //Name of the event
	public $location; //Location
	public $dtstart; //Starting timestamp
	public $dtend; //Ending timestamp
	public $url; //URL of the event
	public $categories; //Type of event
	public $description; //body of the event
	
	/*
		BEGIN:VEVENT
		UID:409BA071-8451-492D-9ACE-EEFFAFB4EED1
		DTEND;TZID=Europe/Stockholm:20100907T110000
		TRANSP:OPAQUE
		SUMMARY:Telemöte Dicore
		DTSTART;TZID=Europe/Stockholm:20100907T100000
		DTSTAMP:20100907T075758Z
		SEQUENCE:0
		BEGIN:VALARM
		X-WR-ALARMUID:4346C2DC-CBB3-4803-A637-01F711903292
		TRIGGER:-PT5M
		DESCRIPTION:Event reminder
		ACTION:DISPLAY
		END:VALARM
		END:VEVENT
	*/
	
	public function __toString()
	{
		$string = "BEGIN:VEVENT\r\n";
		
		if($this->summary)
		{
			$string .= "SUMMARY:".$this->summary."\r\n";
		}
		
		if($this->location)
		{
			$string .= "LOCATION:".$this->location."\r\n";
		}		
		
		if($this->dtstart)
		{
			$string .= "DTSTART;TZID=".date("e").":".date("Ymd\THis", $this->dtstart)."\r\n";
		}
		
		if($this->dtend)
		{
			$string .= "DTEND;TZID=".date("e").":".date("Ymd\THis", $this->dtend)."\r\n";
		}
		
		if($this->description)
		{
			$string .= "DESCRIPTION:".$this->description."\r\n";
		}		
		
		$string .= "END:VEVENT\r\n";
		
		return $string;
	}

	public static function Factory()
	{
		return new ICS_Event();
	}
	
	public function set($options)
	{
		foreach($options as $key => $value)
		{
			$this->{$key} = $value;
		}
		
		return $this;
	}
}