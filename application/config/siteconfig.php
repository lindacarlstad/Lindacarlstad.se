<?php defined('SYSPATH') or die('No direct script access.');

$cache = Cache::instance();

if(!$dbarr = $cache->get('siteconfig'))
{
	$database = DB::select()->from('siteconfig')->execute();

	$dbarr = array();
	
	foreach($database as $item){
		$dbarr[$item['name']] = $item['value'];
	}
	
	$cache->set('siteconfig', $dbarr, 3600*365);
}


$original = array(

	'sitename' 					=> 'Linda Carlstad',
	'releaseyear'				=> '2011',
	'keywords'					=> 'Linda Carlstad, LINDA, Karlstad Universitet, KAU, KAU IT, Webb & Multimedia, Datavetare,',
	'description'				=> '',
	
	'logo'						=> '/layout/logo.svg',
	'template'					=> 'templates/default_template',
	
	'languagecode'				=> 'sv',
	
	'google_analytics_id'		=> null,
);

return Arr::merge($original, $dbarr);