<?php defined('SYSPATH') or die('No direct script access.');

class Tumblr_Write extends Tumblr {

	/**
	 * Create a new post.
	 *
	 *		Tumblr::factory('write')->create($email, $password, $params);
	 *
	 * @param	string	email address
	 * @param	string	password
	 * @param	array	parameters: http://www.tumblr.com/docs/en/api#api_write
	 * @return	mixed
	 */
	public function create($email, $password, array $params)
	{
		if ( ! isset($params['type']))
		{
			throw new Tumblr_Exception('Required parameter not passed: type must be provided');
		}

		// Force XML format
		$this->format = 'xml';
		
		// Set URL
		$this->url = $this->url('write');

		// Execute request
		return $this->request($email, $password, $params);
	}

	/**
	 * Edit a post.
	 *
	 *		Tumblr::factory('write')->edit($email, $password, array(
	 *			'post-id' => $post-id,
	 *			'blog_name' => $blog_name,
	 *			'title' => $title,
	 *		));
	 *
	 * @param	string	email address
	 * @param	string	password
	 * @param	array	parameters: http://www.tumblr.com/docs/en/api#editing_posts
	 * @param	boolean	safe edit means that no data will be lost if it is not set upon updating
	 * @return	mixed
	 */
	public function edit($email, $password, array $params, $safe_edit = TRUE)
	{
		if ( ! isset($params['post-id']))
		{
			throw new Tumblr_Exception('Required parameter not passed: post-id must be provided');
		}

		// Force XML format
		$this->format = 'xml';

		// Read the post to get the original values
		if ($safe_edit)
		{
			if ( ! isset($params['blog_name']))
			{
				throw new Tumblr_Exception('Required parameter not passed: blog_name must be provided');
			}

			// Read the original post
			$read = Tumblr::factory('read')->posts($email, $password, array(
				'blog_name' => $params['blog_name'],
				'id' => $params['post-id'],
			));

			// Set type
			$type = $read->posts->post['type'].'-';

			// Create an array with the original values
			$original = array();

			foreach ($read->posts->post->children() as $name => $value)
			{
				Arr::unshift($original, str_replace($type, '', $name), (string) $value);
			}

			// Merge the original values and the params
			$params = Arr::merge($original, $params);
		}

		// Set URL
		$this->url = $this->url('write');
		
		// Execute request
		return $this->request($email, $password, $params);
	}

	/**
	 * Delete a post.
	 *
	 *		Tumblr::factory('write')->delete($email, $password, $post_id);
	 *
	 * @param	string	email address
	 * @param	string	password
	 * @param	string	post ID
	 * @return	mixed
	 */
	public function delete($email, $password, $post_id)
	{
		// Force XML format
		$this->format = 'xml';

		// Create params array
		$params = array('post-id' => $post_id);

		// Set URL
		$this->url = $this->url('delete');

		// Execute request
		return $this->request($email, $password, $params);
	}

	/**
	 * Reblog a post.
	 *
	 *		Tumblr::factory('write')->delete($email, $password, array(
	 *			'post-id' => $post-id,
	 *			'reblog-key' => $reblog-key,
	 *		));
	 *
	 * @param	string	email address
	 * @param	string	password
	 * @param	array	parameters: http://www.tumblr.com/docs/en/api#reblogging_posts
	 * @return	mixed
	 */
	public function reblog($email, $password, array $params)
	{
		if ( ! isset($params['post-id']) OR ! isset($params['reblog-key']))
		{
			throw new Tumblr_Exception('Required parameter not passed: post-id and reblog-key must be provided');
		}

		// Force XML format
		$this->format = 'xml';

		// Set URL
		$this->url = $this->url('reblog');

		// Execute request
		return $this->request($email, $password, $params);
	}

} // End Tumblr_Write