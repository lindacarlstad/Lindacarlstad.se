<?php defined('SYSPATH') or die('No direct script access.');

abstract class Tumblr {

	protected $format = 'xml';
	protected $url;

	protected $parser = array(
		'xml'  => 'simplexml_load_string',
		'json' => 'json_decode',
	);

	public static function factory($name, array $options = NULL)
	{
		$class = 'Tumblr_'.$name;

		return new $class($options);
	}

	public function __construct(array $options = NULL)
	{
		if (isset($options['format']))
		{
			// Set the response format
			$this->format = trim($options['format']);
		}
	}

	public function parser($format, $value)
	{
		$this->parser[$format] = $value;

		return $this;
	}

	public function url($action, $source = 'www')
	{
		return "http://{$source}.tumblr.com/api/{$action}/{$this->format}";
	}

	public function parse($response)
	{
		if ( ! isset($this->parser[$this->format]))
		{
			// No parser for the requested format
			return $response;
		}

		// Get the parser for this format
		$parser = $this->parser[$this->format];

		// Parse the response
		// @todo: some kind of better solution for ths
		try
		{
			return $parser($response);
		}
		catch (Exception $e)
		{
		    return $response;
		}
	}

	public function request($email = NULL, $password = NULL, array $params = array())
	{
		// If email and password are set include them in params
		if ($email AND $password)
		{
			Arr::unshift($params, 'email', $email);
			Arr::unshift($params, 'password', $password);
		}
		
		// Create query string from params
		$data = http_build_query($params);

		// If email and password set do an authenticated POST request
		if ($email AND $password)
		{
			$options = array(
				CURLOPT_POST => TRUE,
				CURLOPT_POSTFIELDS => $data,
			);
		}
		else
		{
			// Set CURL options to NULL
			$options = NULL;

			// Add query string to base URL
			$this->url = "{$this->url}?{$data}";
		}

		$response = Remote::get($this->url, $options);

		return $this->parse($response);
	}

} // End Tumblr