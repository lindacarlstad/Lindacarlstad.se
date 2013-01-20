<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Abstract PayPal integration.
 *
 * @link  https://cms.paypal.com/us/cgi-bin/?cmd=_render-content&content_ID=developer/library_documentation
 *
 * @package    Kohana
 * @author     Kohana Team
 * @copyright  (c) 2009 Kohana Team
 * @license    http://kohanaphp.com/license.html
 */
abstract class PayPal {

	/**
	 * @var  array  instances
	 */
	public static $instances = array();

	/**
	 * Returns a singleton instance of one of the PayPal classes.
	 *
	 * @param   string  class type (ExpressCheckout, PaymentsPro, etc)
	 * @return  object
	 */
	public static function instance($type)
	{
		if ( ! isset(PayPal::$instances[$type]))
		{
			// Set the class name
			$class = 'PayPal_'.$type;

			// Load default configuration
			$config = Kohana::config('paypal');

			// Create a new PayPal instance with the default configuration
			PayPal::$instances[$type] = new $class($config['username'], $config['password'], $config['signature'], $config['environment']);
		}

		return PayPal::$instances[$type];
	}

	// API username
	protected $_username;

	// API password
	protected $_password;

	// API signature
	protected $_signature;

	// Environment type
	protected $_environment = 'live';

	/**
	 * Creates a new PayPal instance for the given username, password,
	 * and signature for the given environment.
	 *
	 * @param   string  API username
	 * @param   string  API password
	 * @param   string  API signature
	 * @param   string  environment (one of: live, sandbox, sandbox-beta)
	 * @return  void
	 */
	public function __construct($username, $password, $signature, $environment = 'live')
	{
		// Set the API username and password
		$this->_username = $username;
		$this->_password = $password;

		// Set the API signature
		$this->_signature = $signature;

		// Set the environment
		$this->_environment = $environment;
	}

	/**
	 * Returns the NVP API URL for the current environment.
	 *
	 * @return  string
	 */
	public function api_url()
	{
		if ($this->_environment === 'live')
		{
			// Live environment does not use a sub-domain
			$env = '';
		}
		else
		{
			// Use the environment sub-domain
			$env = $this->_environment.'.';
		}

		return 'https://api-3t.'.$env.'paypal.com/nvp';
	}

	/**
	 * Returns the redirect URL for the current environment.
	 *
	 * @see  https://cms.paypal.com/us/cgi-bin/?cmd=_render-content&content_ID=developer/e_howto_html_Appx_websitestandard_htmlvariables#id08A6HF00TZS
	 *
	 * @param   string   PayPal command
	 * @param   array    GET parameters
	 * @return  string
	 */
	public function redirect_url($command, array $params)
	{
		if ($this->_environment === 'live')
		{
			// Live environment does not use a sub-domain
			$env = '';
		}
		else
		{
			// Use the environment sub-domain
			$env = $this->_environment.'.';
		}

		// Add the command to the parameters
		$params = array('cmd' => '_'.$command) + $params;

		return 'https://www.'.$env.'paypal.com/webscr?'.http_build_query($params, NULL, '&');
	}

	/**
	 * Makes a POST request to PayPal NVP for the given method and parameters.
	 *
	 * @see  https://cms.paypal.com/us/cgi-bin/?cmd=_render-content&content_ID=developer/e_howto_api_nvp_NVPAPIOverview
	 *
	 * @throws  Kohana_Exception
	 * @param   string  method to call
	 * @param   array   POST parameters
	 * @return  array
	 */
	protected function _post($method, array $params)
	{
		// Create POST data
		$post = array(
			'METHOD'    => $method,
			'VERSION'   => 51.0,
			'USER'      => $this->_username,
			'PWD'       => $this->_password,
			'SIGNATURE' => $this->_signature,
		) + $params;

		// Create a new curl instance
		$curl = curl_init();

		// Set curl options
		curl_setopt_array($curl, array(
			CURLOPT_URL            => $this->api_url(),
			CURLOPT_POST           => TRUE,
			CURLOPT_POSTFIELDS     => http_build_query($post, NULL, '&'),
			CURLOPT_SSL_VERIFYPEER => FALSE,
			CURLOPT_SSL_VERIFYHOST => FALSE,
			CURLOPT_RETURNTRANSFER => TRUE,
		));

		if (($response = curl_exec($curl)) === FALSE)
		{
			// Get the error code and message
			$code  = curl_errno($curl);
			$error = curl_error($curl);

			// Close curl
			curl_close($curl);

			throw new Kohana_Exception('PayPal API request for :method failed: :error (:code)',
				array(':method' => $method, ':error' => $error, ':code' => $code));
		}

		// Close curl
		curl_close($curl);

		// Parse the response
		parse_str($response, $data);

		if ( ! isset($data['ACK']) OR strpos($data['ACK'], 'Success') === FALSE)
		{
			throw new Kohana_Exception('PayPal API request for :method failed: :error (:code)',
				array(':method' => $method, ':error' => $data['L_LONGMESSAGE0'], ':code' => $data['L_ERRORCODE0']));
		}

		return $data;
	}

} // End PayPal
