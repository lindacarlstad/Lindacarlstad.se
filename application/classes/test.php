<?php defined('SYSPATH') or die('No direct script access.');

class Test extends Kohana_HTML {

	public static function time($time, $stop = NULL, $fuzzy_span = TRUE, $attributes = array(), $format = "%A %e %B %R")
	{
		$datetime = strftime("%Y-%m-%dT%T", $time);		
	
		if($stop !== NULL AND $stop > $time)
		{
			$datetime .= '-';
			
			if(strftime("%Y-%m-%d", $time) !== strftime("%Y-%m-%d", $stop))
			{
				$datetime .= strftime("%Y-%m-%d", $stop).'T';
			}		
			$datetime .= strftime("%T", $time).'Z';
		}
		
		$content = ($fuzzy_span) ? Date::fuzzy_span($time, time()) : strftime($format, $time);
	
		return '<time datetime="'.$datetime.'" title="'.strftime($format, $time).'"'.self::attributes($attributes).'>'.$content.'</time>';
	}

}