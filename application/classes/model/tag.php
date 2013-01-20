<?php defined('SYSPATH') or die('No direct script access.');
class Model_Tag extends ORM {

	protected $_has_many = array(
		'news' => array('through' => 'news_tags'),
		'forums' => array('through' => 'forums_tags'),
	);

	public function set_or_get(array $tags)
	{
		$found_tags = array();
		foreach($tags as $tag)
		{
			if(strlen($tag) > 1)
			{
				$tag = trim($tag);
				$exists = ORM::factory('tag')->where('name', '=', $tag)->find();
				if($exists->loaded())
				{
					$found_tags[] = $exists->id;
				}
				else
				{
					$new_tag = ORM::Factory('tag');
					$new_tag->name = $tag;
					$new_tag->save();
					$found_tags[] = $new_tag->id;
				}
			}
		}
		return $found_tags;
	}
}