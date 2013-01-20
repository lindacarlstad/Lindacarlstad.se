<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Account extends Controller {
	public function action_logout()
	{		
		AUTH::instance()->logout();
		$this->request->redirect();
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