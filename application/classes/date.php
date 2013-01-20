<?php defined('SYSPATH') or die('No direct script access.');

class Date extends Kohana_Date {

	public static function fuzzy_span($timestamp, $local_timestamp = NULL)
	{
		return self::detailed_span($timestamp, $local_timestamp);
	}

	/**
	 * Returns the difference between a time and now in a "fuzzy" way.
	 * Displaying a fuzzy time instead of a date is usually faster to read and understand.
	 *
	 *     $span = Date::fuzzy_span(time() - 10); // "moments ago"
	 *     $span = Date::fuzzy_span(time() + 20); // "in moments"
	 *
	 * A second parameter is available to manually set the "local" timestamp,
	 * however this parameter shouldn't be needed in normal usage and is only
	 * included for unit tests
	 *
	 * @param   integer  "remote" timestamp
	 * @param   integer  "local" timestamp, defaults to time()
	 * @return  string
	 */
	public static function detailed_span($timestamp, $local_timestamp = NULL)
	{
				
		$local_timestamp = ($local_timestamp === NULL) ? time() : (int) $local_timestamp;

		// Determine the difference
		$offset = abs($local_timestamp - $timestamp);
		
		$time = Date::span($local_timestamp, $timestamp, 'years,months,weeks,days,hours,minutes,seconds');


		if ($offset <= Date::MINUTE)
		{
			$span = __(':value :seconds', array(':value' => $time['seconds'], ':seconds' => __(Inflector::plural('second', $time['seconds']))));
		}
		elseif ($offset < Date::HOUR)
		{
			$span = __(':value :minutes', array(':value' => $time['minutes'], ':minutes' => __(Inflector::plural('minute', $time['minutes']))));
		}
		elseif ($offset < (Date::DAY))
		{
			$span = __(':value :hours', array(':value' => $time['hours'], ':hours' => __(Inflector::plural('hour', $time['hours']))));
		}
		elseif ($offset < (Date::WEEK))
		{
			$span = __(':value :days', array(':value' => $time['days'], ':days' => __(Inflector::plural('day', $time['days']))));
		}
		elseif ($offset < (Date::MONTH))
		{
			$span = __(':value :weeks', array(':value' => $time['weeks'], ':weeks' => __(Inflector::plural('week', $time['weeks']))));
		}
		elseif ($offset < (Date::YEAR))
		{
			$span = __(':value :months', array(':value' => $time['months'], ':months' => __(Inflector::plural('month', $time['months']))));
		}
		else
		{
			$span = __(':value :years', array(':value' => $time['years'], ':years' => __(Inflector::plural('year', $time['years']))));
		}

		if ($timestamp <= $local_timestamp)
		{
			// This is in the past
			return __('about ').$span.__(' ago');
		}
		else
		{
			// This in the future
			return __('in about').$span;
		}
	}
}