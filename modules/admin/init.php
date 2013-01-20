<?php defined('SYSPATH') or die('No direct script access.');

Route::set('admin managing', 'admin/settings(/<controller>(/<action>(/<id>)))', array(
		'directory' => '(settings|manage)',
	))
	->defaults(array(
		'controller' => 'start',
		'action'     => 'index',
		'directory'  => 'settings'
	));

Route::set('admin', 'admin(/<controller>(/<action>(/<parameter>(/<parameter2>))))')
	->defaults(array(
		'controller' => 'home',
		'action' => 'index',
	));
	
