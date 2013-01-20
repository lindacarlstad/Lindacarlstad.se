<?php defined('SYSPATH') or die('No direct script access.');

return array(

	'compress' => FALSE,

	'css' => array(
		
		//filepath to were the less files is stored with ending /.
		'filepath' => APPPATH.'media/less/',
		
		'storage' => 'media/css/',
		
	),
	
	'js' => array(
		//filepath to where the javascript files is stored with ending /.
		'filepath' => APPPATH.'media/js/',
		
		'storage' => 'media/js/',
		
		//code to be written BEFORE all javascript assets is included (except for the framework-files)
		'before' => "window.addEvent('domready', function(){\n",
		
		//code to be written AFTER all javascript assets is included (except for the framework-files)
		'after' => "\n});",
		
		
		'framework' => array(
			//full path to one or multiple files used for as javascript framework.
			APPPATH.'media/mootools/mootools-core-1.3.2.js',
			APPPATH.'media/mootools/mootools-more-1.3.2.1.js',
			APPPATH.'media/mootools/powertools-1.0.5.js',
			
			APPPATH.'media/mootools/autocompleter/autocompleter-1.1.2.js',
			APPPATH.'media/mootools/autocompleter/autocompleter.request.js',
			APPPATH.'media/mootools/autocompleter/observer.js',				
		),
		
	),
	
);