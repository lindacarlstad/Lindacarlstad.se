<?php defined('SYSPATH') or die('No direct script access.');

class Text extends Kohana_Text {


	/**
	 * Creates and url-friendly string from the passed string
	 * @param string $string
	 * @return string
	 */
	public static function urlify($string, $maxLength = 124){
		$string = strtolower($string);
		
		$string = str_replace(array('å','ä','ö'), array('a','a','o'), $string);
   		$string = preg_replace("/[^a-z0-9\s-]/", " ", $string);
    	$string = trim(preg_replace("/[\s-]+/", " ", $string));
    	$string = trim(substr($string, 0, $maxLength));
    	$string = preg_replace("/\s/", "-", $string);
	
    	return $string;
	}
	
	public static function twitter_linkify($status_text)
	{
		// linkify URLs
  		$status_text = preg_replace(
    		'/(https?:\/\/\S+)/',
    		'<a href="\1">\1</a>',
    		$status_text
  		);

  		// linkify twitter users
  		$status_text = preg_replace(
    		'/(^|\s)@(\w+)/',
    		'\1<a href="http://twitter.com/\2" class="twitter-mention">@\2</a>',
    		$status_text
  		);

 		 // linkify tags
  		$status_text = preg_replace(
    		'/(^|\s)#(\w+)/',
    		'\1<a href="http://search.twitter.com/search?q=%23\2" class="twitter-tag">#\2</a>',
    		$status_text
  		);

  		return $status_text;
	}
	

}
