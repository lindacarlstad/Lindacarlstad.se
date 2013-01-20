<?php defined("SYSPATH") or die("No direct script access.");

class Ics_Core {
	
	private $events;
	
	public static function Factory()
	{
		return new Ics();
	}
	
	public function add(ICS_Event $event)
	{	
		$this->events[] = $event;
	}
	
	public function execute()
	{	
		$ics = "BEGIN:VCALENDAR\r\n";
		$ics .= "METHOD:PUBLISH\r\n";
		$ics .= "VERSION:2.0\r\n";
		$ics .= "X-WR-CALNAME:Linda Carlstad\r\n";
		$ics .= "PRODID:-//Lindacarlstad.se //SV\r\n";
		$ics .= "X-APPLE-CALENDAR-COLOR:#6e1739\r\n";
		$ics .= "X-WR-TIMEZONE:Europe/Stockholm\r\n";
		$ics .= "CALSCALE:GREGORIAN\r\n";
		$ics .= "BEGIN:VTIMEZONE\r\n";
		$ics .= "TZID:Europe/Stockholm\r\n";
		$ics .= "BEGIN:DAYLIGHT\r\n";
		$ics .= "TZOFFSETFROM:+0100\r\n";
		$ics .= "RRULE:FREQ=YEARLY;BYMONTH=3;BYDAY=-1SU\r\n";
		$ics .= "DTSTART:19810329T020000\r\n";
		$ics .= "TZNAME:CEST\r\n";
		$ics .= "TZOFFSETTO:+0200\r\n";
		$ics .= "END:DAYLIGHT\r\n";
		$ics .= "BEGIN:STANDARD\r\n";
		$ics .= "TZOFFSETFROM:+0200\r\n";
		$ics .= "RRULE:FREQ=YEARLY;BYMONTH=10;BYDAY=-1SU\r\n";
		$ics .= "DTSTART:19961027T030000\r\n";
		$ics .= "TZNAME:CET\r\n";
		$ics .= "TZOFFSETTO:+0100\r\n";
		$ics .= "END:STANDARD\r\n";
		$ics .= "END:VTIMEZONE\r\n";
		$ics .= "BEGIN:VTIMEZONE\r\n";
		$ics .= "TZID:Etc/GMT-2\r\n";
		$ics .= "BEGIN:STANDARD\r\n";
		$ics .= "TZOFFSETFROM:+0200\r\n";
		$ics .= "DTSTART:20010101T000000\r\n";
		$ics .= "TZNAME:GMT+02:00\r\n";
		$ics .= "TZOFFSETTO:+0200\r\n";
		$ics .= "END:STANDARD\r\n";
		$ics .= "END:VTIMEZONE\r\n";
		
		foreach($this->events as $event){
													
			$ics .= $event;
		}
		
		$ics .= "END:VCALENDAR\r\n";

		return $ics;
	}
}