<?php defined('SYSPATH') OR die('No direct access allowed.');

	if(!class_exists('markdown_parser') AND !class_exists('')){
		require_once 'vendor/markdown/markdown.php';
	}
