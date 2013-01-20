<?php defined('SYSPATH') or die('No direct script access.');

class Twitter_Search extends Twitter {

	/**
	 * @link  http://dev.twitter.com/doc/get/statuses/public_timeline
	 */
	public function search(OAuth_Consumer $consumer, OAuth_Token $token = NULL, array $params = NULL)
	{
		// Create a new GET request with the required parameters
		$request = OAuth_Request::factory('resource', 'GET', 'http://search.twitter.com/search.json', array(
				'oauth_consumer_key' => $consumer->key,
			));

		// Authorization is not required
		$request->required('oauth_token', FALSE);

		if ($token)
		{
			// Include the token
			$params['oauth_token'] = $token->token;
		}

		if ($params)
		{
			// Load user parameters
			$request->params($params);
		}

		// Sign the request using only the consumer, no token is required
		$request->sign($this->signature, $consumer, $token);

		// Create a response from the request
		$response = $request->execute();

		return $this->parse($response);
	}

}
