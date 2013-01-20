<?php defined('SYSPATH') or die('No direct script access.');

class Textinator_Core {

	public static function markup($text)
	{
		//$parser = new MarkdownExtra_Parser();
		//return $parser->transform($text);
		
		return Markdown($text);
	}

	
	
}