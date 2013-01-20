<?php defined('SYSPATH') or die('No direct script access.');

class URL extends Kohana_URL {
	
	public static function linkToUri($uri){
		$string = "";
		$split_uri = explode('/', $uri);
		$size = count($split_uri);
	
		if((isset($split_uri[2])) && ($split_uri[$size-1] !== 'index')){
		
			for($i=1; $i < $size ;$i++){
				$string .= '/'.$split_uri[$i];
			}
			
		}
		else if((isset($split_uri[1])) && ($split_uri[1] !== 'home')){
			for($i=1; $i < $size-1 ;$i++){
				$string .= '/'.$split_uri[$i];
			}
		}
	
		return '/admin'.$string.'/';
	}
	
	public static function controller($uri){
		$split = explode('/', $uri);
		return $split[1];
	}
	
}