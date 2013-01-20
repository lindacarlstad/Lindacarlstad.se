<?php defined('SYSPATH') or die('No direct script access.');

class Tumblr_User extends Tumblr {

	/**
	 * Get user info.
	 *
	 *		Tumblr::factory('user')->authenticate($email, $password);
	 *
	 * @param	string	email address
	 * @param	string	password
	 * @return	mixed
	 */
	public function authenticate($email, $password)
	{
		// Force XML format
		$this->format = 'xml';

		// Set URL
		$this->url = $this->url('authenticate');

		// Execute request
		return $this->request($email, $password);
	}

	/**
	 * Like a post.
	 *
	 *		Tumblr::factory('user')->like($email, $password, array(
	 *			'post-id' => $post_id,
	 *			'reblog-key' => $reblog-key,
	 *		));
	 *
	 * @param	string	email address
	 * @param	string	password
	 * @param	array	parameters: http://www.tumblr.com/docs/en/api#api_liking
	 * @return	mixed
	 */
	public function like($email, $password, array $params)
	{
		if ( ! isset($params['post-id']) OR  ! isset($params['reblog-key']))
		{
			throw new Tumblr_Exception('Required parameter not passed: post-id and reblog-key must be provided');
		}

		// Set URL
		$this->url = $this->url('like');

		// Execute request
		return $this->request($email, $password, $params);
	}

	/**
	 * Unlike a post.
	 *
	 *		Tumblr::factory('user')->unlike($email, $password, array(
	 *			'post-id' => $post_id,
	 *			'reblog-key' => $reblog-key,
	 *		));
	 *
	 * @param	string	email address
	 * @param	string	password
	 * @param	array	parameters: http://www.tumblr.com/docs/en/api#api_liking
	 * @return	mixed
	 */
	public function unlike($email, $password, array $params)
	{
		if ( ! isset($params['post-id']) OR  ! isset($params['reblog-key']))
		{
			throw new Tumblr_Exception('Required parameter not passed: post-id and reblog-key must be provided');
		}

		// Set URL
		$this->url = $this->url('unlike');

		// Execute request
		return $this->request($email, $password, $params);
	}

} // End Tumblr_User