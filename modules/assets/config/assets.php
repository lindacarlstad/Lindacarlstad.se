<?php defined('SYSPATH') or die('No direct script access.');

return array(

	'compress' => TRUE,

	'css' => array(
		
		//filepath to were the less files is stored with ending /.
		'filepath' => APPPATH.'media/less/',
		
		'storage' => 'media/css/',
		
	),
	
	'js' => array(
		//filepath to where the javascript files is stored with ending /.
		'filepath' => APPPATH.'media/js/',
		
		'storage' => 'media/js/',
		
		
		'framework' => array(
			/**
			 * full path to one or multiple files used for as javascript framework.
			 *
			 * Ex: APPPATH.'media/mootools/mootools-core.js',
			 */
			
		)
		
	)
	
);