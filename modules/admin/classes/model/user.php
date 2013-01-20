<?php defined('SYSPATH') or die('No direct access allowed.');
 
class Model_User extends Model_Auth_User {

	/**
	 * Rules for the user model. Because the password is _always_ a hash
	 * when it's set,you need to run an additional not_empty rule in your controller
	 * to make sure you didn't hash an empty string. The password rules
	 * should be enforced outside the model or with a model helper method.
	 *
	 * @return array Rules
	 */
	public function rules()
	{
		return array(
			'name' => array(
				array('not_empty'),
				array('min_length', array(':value', 2)),
				array('max_length', array(':value', 32)),
			),
			'surname' => array(
				array('not_empty'),
				array('min_length', array(':value', 2)),
				array('max_length', array(':value', 32)),
			),
			'username' => array(
				array('not_empty'),
				array('min_length', array(':value', 4)),
				array('max_length', array(':value', 32)),
				array('regex', array(':value', '/^[-\pL\pN_.]++$/uD')),
				array(array($this, 'username_available'), array(':validation', ':field')),
			),
			'password' => array(
				array('not_empty'),
			),
			'email' => array(
				array('not_empty'),
				array('min_length', array(':value', 4)),
				array('max_length', array(':value', 127)),
				array('email'),
				array(array($this, 'email_available'), array(':validation', ':field')),
			),
		);
	}


}