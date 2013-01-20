<?php defined('SYSPATH') or die('No direct script access.');

class Blogger_User extends Blogger {

	/**
	 * Retrieve list of blogs.
	 *
	 * 		Blogger::factory('user')->blogs($consumer, $token, $profile_id);
	 *
	 * @param   OAuth_Consumer	consumer
	 * @param   OAuth_Token		token
	 * @param   string			blog ID
	 * @param   string			profile ID, if set to 'default' the currently authenticated user's profile ID is used
	 * @return  mixed
	 */
	public function blogs(OAuth_Consumer $consumer, OAuth_Token $token, $profile_id = 'default')
	{
		// Create a new GET request with the required parameters
		$request = OAuth_Request::factory('resource', 'GET', $this->url($profile_id, 'blogs'), array(
				'oauth_consumer_key' => $consumer->key,
				'oauth_token' => $token->token,
			));

		// Sign the request using the consumer and token
		$request->sign($this->signature, $consumer, $token);

		// Create a response from the request
		$response = $request->execute();

		return $this->parse($response);
	}

	/**
	 * Get info about token.
	 *
	 * 		Blogger::factory('user')->token_info($consumer, $token);
	 *
	 * @param   OAuth_Consumer	consumer
	 * @param   OAuth_Token		token
	 * @return  mixed
	 */
	public function token_info(OAuth_Consumer $consumer, OAuth_Token $token)
	{
		// Create a new GET request with the required parameters
		$request = OAuth_Request::factory('resource', 'GET', $this->url_authsub('AuthSubTokenInfo'), array(
				'oauth_consumer_key' => $consumer->key,
				'oauth_token' => $token->token,
			));

		// Sign the request using the consumer and token
		$request->sign($this->signature, $consumer, $token);

		// Create a response from the request
		$response = $request->execute();

		return $response;
	}

	/**
	 * Revoke a valid token.
	 *
	 * 		Blogger::factory('user')->revoke_token($consumer, $token);
	 *
	 * @param   OAuth_Consumer	consumer
	 * @param   OAuth_Token		token
	 * @return  mixed
	 */
	public function revoke_token(OAuth_Consumer $consumer, OAuth_Token $token)
	{
		// Create a new GET request with the required parameters
		$request = OAuth_Request::factory('resource', 'GET', $this->url_authsub('AuthSubRevokeToken'), array(
				'oauth_consumer_key' => $consumer->key,
				'oauth_token' => $token->token,
			));

		// Sign the request using the consumer and token
		$request->sign($this->signature, $consumer, $token);

		// Create a response from the request
		$response = $request->execute();

		return $response;
	}

} // End Blogger_User