<?php defined('SYSPATH') or die('No direct script access.');

class Tumblr_Read extends Tumblr {

	/**
	 * Read posts.
	 *
	 *		Tumblr::factory('read')->posts($email, $password, , array(
	 *			'blog_name' => $blog_name,
	 *		));
	 *
	 * @param	string	email address (optional, use for including private posts)
	 * @param	string	password (optional, use for including private posts)
	 * @param	array	parameters: http://www.tumblr.com/docs/en/api#api_read
	 * @return	mixed
	 */
	public function posts($email = NULL, $password = NULL, array $params)
	{
		if ( ! isset($params['blog_name']))
		{
			throw new Tumblr_Exception('Required parameter not passed: blog_name must be provided');
		}

		// Set URL
		$this->url = $this->url('read', $params['blog_name']);

		// Remove blog name from params
		unset($params['blog_name']);

		// Execute request
		return $this->request($email, $password, $params);
	}

	/**
	 * Read dashboard.
	 *
	 *		Tumblr::factory('read')->dashboard($email, $password);
	 *
	 * @param	string	email address
	 * @param	string	password
	 * @param	array	parameters: http://www.tumblr.com/docs/en/api#api_dashboard
	 * @return	mixed
	 */
	public function dashboard($email, $password, array $params = array())
	{
		// Set URL
		$this->url = $this->url('dashboard');

		// Execute request
		return $this->request($email, $password, $params);
	}

	/**
	 * Read liked posts.
	 *
	 *		Tumblr::factory('read')->likes($email, $password);
	 *
	 * @param	string	email address
	 * @param	string	password
	 * @param	array	parameters: http://www.tumblr.com/docs/en/api#api_likes
	 * @return	mixed
	 */
	public function likes($email, $password, array $params = array())
	{
		// Force XML format
		$this->format = 'xml';

		// Set URL
		$this->url = $this->url('likes');

		// Execute request
		return $this->request($email, $password, $params);
	}

	/**
	 * Read pages.
	 *
	 *		Tumblr::factory('read')->pages($email, $password, array(
	 *			'blog_name' => $blog_name,
	 *		));
	 *
	 * @param	string	email address (optional, use for including private pages)
	 * @param	string	password (optional, use for including private pages)
	 * @param	array	parameters: http://www.tumblr.com/docs/en/api#api_pages
	 * @return	mixed
	 */
	public function pages($email = NULL, $password = NULL, array $params)
	{
		if ( ! isset($params['blog_name']))
		{
			throw new Tumblr_Exception('Required parameter not passed: blog_name must be provided');
		}

		// Force XML format
		$this->format = 'xml';

		// Set URL
		$this->url = $this->url('pages', $params['blog_name']);

		// Remove blog name from params
		unset($params['blog_name']);

		// Execute request
		return $this->request($email, $password, $params);
	}

} // End Tumblr_Read