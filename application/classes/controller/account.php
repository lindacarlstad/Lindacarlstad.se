<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Account extends Controller {
	protected $session; 
	public function action_logout()
	{		
		AUTH::instance()->logout();
		$this->request->redirect();
	}
	
	public function action_register_pay()
	{
		if (AUTH::Instance()->get_user() == NULL)
		{
			if (isset($_POST['redirect']) && !empty($_POST['redirect']) && $_POST['redirect'] == 'redirect')
			{
				$this->session = Session::instance();
								
				if (isset($_POST['email']) && !empty($_POST['email']) &&
					isset($_POST['name']) && !empty($_POST['name']) &&
					isset($_POST['surname']) && !empty($_POST['surname']) &&
					isset($_POST['password']) && !empty($_POST['password']) &&
					isset($_POST['password_confirm']) && !empty($_POST['password_confirm']) &&
					$_POST['password'] == $_POST['password_confirm'])
				{
					$requestParams = array(
					   'RETURNURL' => 'http://lindacarlstad.se/account/register_success',
					   'CANCELURL' => 'http://lindacarlstad.se/account/register_cancelled'
					);
					
					$orderParams = array(	
					   'PAYMENTREQUEST_0_AMT' => '1',
					   'PAYMENTREQUEST_0_SHIPPINGAMT' => '0',
					   'PAYMENTREQUEST_0_CURRENCYCODE' => 'SEK',
					   'PAYMENTREQUEST_0_ITEMAMT' => '1'
					);
					$items = array(
						   "L_PAYMENTREQUEST_0_NAME0" => 'Medlemsavgift',
						   "L_PAYMENTREQUEST_0_AMT0" => '1',
						   "L_PAYMENTREQUEST_0_QTY0" => '1'
						);
						
					
					$paypal = new Paypal();
					$response = $paypal -> request('SetExpressCheckout',$requestParams + $orderParams + $items + array("SOLUTIONTYPE" => 'Sole'));
					if(is_array($response) && $response['ACK'] == 'Success') 
					{						
						//Temp registrering, fult men hur fan gör man annars?
						$this->session->set('reg0', $_POST['email']);
						$this->session->set('reg1', $_POST['name']);
						$this->session->set('reg2', $_POST['surname']);
						$this->session->set('reg3', $_POST['password']);
						$this->session->set('reg4', $response['TOKEN']);
						  
						$this->response->body(View::factory('account/account_register_pay')
							->bind('errors', $errors)
							->bind('values', $values)
							->bind('token', $response['TOKEN']));	
					}
					else
					{
						$_POST['redirect'] = "";
						$errors = "Kan inte koppla upp mot Paypal för tillfället!";
						$this->response->body(View::factory('account/account_register_pay')
						->bind('errors', $errors)
						->bind('values', $values)
						);
					}
				}
				elseif ($_POST['password'] != $_POST['password_confirm']) 
				{
					$_POST['redirect'] = "";
					$errors = "Lösenorden stämmer inte överens!";
					$this->response->body(View::factory('account/account_register_pay')
					->bind('errors', $errors)
					->bind('values', $values)
					);
				}
				else
				{
					$_POST['redirect'] = "";
					$errors = "Något fält är tomt!";
					$this->response->body(View::factory('account/account_register_pay')
					->bind('errors', $errors)
					->bind('values', $values));
				}
			}
			else
			{
				$_POST['redirect'] = "";
				$errors = "";
				$this->response->body(View::factory('account/account_register_pay')
				->bind('errors', $errors)
				->bind('values', $values));
			}
		}
		else
		{
			$this->request->redirect('/news/');
		}
	}
	
	public function action_register_success()
	{
		$this->session = Session::instance();
		if(
			isset($_GET['token']) && !empty($_GET['token']) && 
			isset($_GET['PayerID']) && !empty($_GET['PayerID']) &&
			strcmp($this->session->get('reg4'), $_GET['token']) == 0
			)
		{
			$regArray = array('email' => $this->session->get('reg0'), 
			'name' => $this->session->get('reg1'), 
			'surname' => $this->session->get('reg2'), 
			'password' => $this->session->get('reg3'));
			$user = ORM::factory('user')->values($regArray, array('email', 'name', 'surname', 'password'));
			try {
					$user->check();
					$user->save();
					
					$role = ORM::Factory('role', 1);
					$user->add('roles', $role);
	
					AUTH::Instance()->force_login($user);
					$this->request->redirect('/account/registered/');
					session_destroy();
			}
			catch(ORM_Validation_Exception $e)
			{
				$errors = $e->errors('register');
      			$values = $_POST;
			}
		}/*
		$errors[] = $this->session->get('reg4');
		$errors[] = $_GET['token'];
		$errors[] = strcmp($this->session->get('reg4'), $_GET['token']);
		$errors[] = isset($_GET['token']) && !empty($_GET['token']);
		$errors[] = isset($_GET['PayerID']) && !empty($_GET['PayerID']);
		 */
		$this->response->body(View::factory('account/account_registerDebug')
				 	->bind('errors', $errors)
					->bind('values', $values)
					->bind('regArray', $regArray));	
		 //DEBUG
		 /*
		 $this->session = Session::instance();
		 $regArray = array($this->session->get('reg0'), 
		 $this->session->get('reg1'), 
		 $this->session->get('reg2'), 
		 $this->session->get('reg3'), 
		 $this->session->get('reg4'));
		 
		 $tempId = $this->session->id();
		 
		 $this->response->body(View::factory('account/account_registerDebug')
		 	->bind('regArray', $regArray)
			->bind('sessionId', $tempId));	
		  */
	}
	
	public function action_register_cancelled()
	{
		$this->template->content = View::factory('account/account_register_cancelled');
	}
	
	public function action_register()
	{
		if($this->request->param('id') !== '5Dyn52Op0U')
		{
			throw new HTTP_Exception_404('The requested uri :uri could not be found', array(':uri' => $this->request->uri()));
		}
	
		if(Arr::get($_POST, 'submit', FALSE))
		{		
			$user = ORM::factory('user')->values($_POST, array('email', 'name', 'surname', 'password'));
			
			try {
			
				$user->check();
				$user->save();
				
				$role = ORM::Factory('role', 1);
				$user->add('roles', $role);

				AUTH::Instance()->force_login($user);
				$this->request->redirect('/account/registered/');
			}
			catch(ORM_Validation_Exception $e)
			{
				$errors = $e->errors('register');
      	$values = $_POST;
			}
		}
	
		$this->response->body(View::factory('account/account_register')
			->bind('errors', $errors)
			->bind('values', $values));
	}

	
	public function action_signup()
	{
		$key = $this->request->param('id');		
		
		$invite = ORM::factory('invite', array('key' => $key));
		if(!$key OR !$invite->loaded())
		{
			echo 'no key';
			throw new HTTP_Exception_404('The requested uri :uri could not be found', array(':uri' => $this->request->uri()));
		}
		
		if(Arr::get($_POST, 'submit', FALSE))
		{
			echo Debug::vars($_POST);	
				
			$user = ORM::factory('user')->values($_POST, array('email', 'name', 'surname', 'password'));
			
			try{
				$user->check();
				$user->save();
				
				$role = ORM::Factory('role', 1);
				$user->add('roles', $role);
				
				$invite->delete();
				AUTH::Instance()->force_login($user);
				$this->request->redirect('/account/registered/');
			}
			catch (ORM_Validation_Exception $e)
      {
      	$errors = $e->errors('register');
        $values = $_POST;
      }
    }
		
		$this->response->body(View::factory('account/account_signup')
			->bind('invite', $invite)
			->bind('errors', $errors)
			->bind('values', $values));
		
	}
	
	public function action_recover()
	{
		$error = "";
		if (!Arr::Get($_POST, 'mail'))
			$this->response->body(View::factory('account/account_recover')
			->bind('error', $error));
		else
		{
			if (!filter_var(Arr::Get($_POST, 'mail'), FILTER_VALIDATE_EMAIL))
			{
				$error = "Formatet på E-postadressen är inkorrekt!";
				$this->response->body(View::factory('account/account_recover')
				->bind('error', $error));
			}
			else
			{
				$userExist = ORM::factory('user')->where('email','=',Arr::Get($_POST, 'mail'))->find();
				if (!$userExist->loaded())
				{
					$error = "Det finns ingen användare med denna E-postadress";
					$this->response->body(View::factory('account/account_recover')
					->bind('error', $error));
				}				
				else 
				{			
					$oldToken = ORM::factory('recoverToken')->where('userId', '=', $userExist->id)->find();
					if ($oldToken->loaded())
						$oldToken->delete();
					
					$newToken = ORM::factory('recoverToken');
					$newToken->token = $newToken->make_key();
					$newToken->userId = $userExist->id;
					$newToken->save();
					
					$to = Arr::Get($_POST, 'mail');
					$from = "noreply@lindacarlstad.se";
					$headers = "From: " . $from . "\r\n" .'MIME-Version: 1.0' . "\r\n" . 'Content-type: text/plain; charset=UTF-8' . "\r\n";
					$subject = "LindaCarlstad, återkoppling (glömt lösenord)";
					$link = "http://lindacarlstad.se/account/newpassword?token=". $newToken->token;
					$msg = "Hej!\r\n\r\nKlicka på denna länk:\r\n$link\r\nför att skapa ett nytt lösenord.\r\n\r\n-Linda Carlstad";
					mail($to, $subject, $msg, $headers);
					$this->request->redirect('account/recover_no_refresh/');
				}
				
			}
		}
	}

	public function action_recover_no_refresh()
	{
		$this->response->body(View::factory('account/account_completeRecover'));
	}
	
	public function action_newpassword()
	{
		$error = "";
		if (Arr::get($_GET, 'token'))
		{
			$token = ORM::factory('recoverToken')->where('token', '=', Arr::get($_GET, 'token'))->find();
			if (!$token-> loaded())
			{
				$error = "Din token har ett felaktigt värde, vänligen gå till <a href='recover'>Http://lindacarlstad.se/account/recover</a> och skapa ett nytt.";
				$this->response->body(View::factory('account/account_recoverError') 
				->bind('error', $error));						
			}
			else
			{
				$tokenVal = Arr::get($_GET, 'token');
				$error = "";
				$this->response->body(View::factory('account/account_newpassword')
				->bind('error', $error)
				->bind('token', $tokenVal));				
			}
		}
		else
		{
			if (!Arr::Get($_POST, 'pw') || !Arr::Get($_POST, 'pw_confirm'))
			{
				$error = "Nu missade du något!";
				$tokenVal = Arr::get($_POST, 'token');
				$this->response->body(View::factory('account/account_newpassword')
					->bind('error', $error)
					->bind('token', $tokenVal));
			}
			else
			{
				if(!(Arr::Get($_POST, 'pw') == Arr::Get($_POST, 'pw_confirm')))
				{
					$error = "Lösenorden stämmer inte överens med varandra!";
					$tokenVal = Arr::get($_POST, 'token');
					$this->response->body(View::factory('account/account_newpassword')
					->bind('error', $error)
					->bind('token', $tokenVal));
				}
				else
				{
					$token = ORM::factory('recoverToken')->where('token', '=', Arr::Get($_POST, 'token'))->find();
					if (!$token-> loaded())
					{
						$error = "Din token har ett felaktigt värde, vänligen gå till <a href='recover'>Http://lindacarlstad.se/account/recover</a> och skapa ett nytt.";
						$this->response->body(View::factory('account/account_recoverError') 
						->bind('error', $error));						
					}
					else
					{
						$user = ORM::factory('user')->where('id', '=', $token->userId)->find();
						
						//nytt lösenord?!?!
						//$user->password = Auth::instance()->hash(Arr::Get($_POST, 'pw'));
						$user->password = Arr::Get($_POST, 'pw');
						$user->save();
						$token->delete();
						//$error = "Lösenordet har ändrats";
						//$error .= "<br>".$user->password."<br>".Auth::instance()->hash(Arr::Get($_POST, 'pw'));
						$this->request->redirect('account/newpassword_no_refresh/');
					}
				}
			}
						
		}
	}
	
	public function action_newpassword_no_refresh()
	{
		$this->response->body(View::factory('account/account_completeNewPassword'));
	}
	
	public function action_registered()
	{
		$user = Auth::Instance()->get_user();
		$this->response->body(View::factory('account/account_registered')
			->bind('user', $user));
	}
}