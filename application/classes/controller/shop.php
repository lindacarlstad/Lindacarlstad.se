<?php defined('SYSPATH') OR die('No Direct Script Access');
 
Class Controller_shop extends Templating
{
	protected $session; 
    public function action_index()
    {
    	$session = Session::instance();
		if (!(isset($_SESSION['items_count'])))
		{
			$_SESSION['items_count'] = 0;
			$_SESSION['total'] = 0;
		}
    	$items = DB::select()->from('shop')->execute();
		$this->template->content = View::factory('shop/items')
		->bind('items', $items);
    }
	public function action_cart()
	{
		// final version
		
		//Kontrollera ifall man är inloggad
		if (AUTH::Instance()->get_user() != NULL)
		{
			if (isset($_POST['add_item']))
			{
				$exist = FALSE;	
				for ($i=0; $i < $_SESSION['items_count']; $i++) 
				{
					if ($_SESSION['item'.$i.'id'] == $_POST['item_id'])
					{
						$_SESSION['item'.$i.'qty'] += $_POST['quantity'];
						$_SESSION['total'] += ($_SESSION['item'.$i.'total']/($_SESSION['item'.$i.'qty']-1));
						$_SESSION['item'.$i.'total'] = ($_SESSION['item'.$i.'total']/($_SESSION['item'.$i.'qty']-1)) * $_SESSION['item'.$i.'qty']; //(Old total/old qty)*new qty
						 
						$exist = TRUE;
					}
				}
				if (!$exist)
				{
					$item = DB::select()->from('shop')->where('id','=',$_POST['item_id'])->execute();
					
					$_SESSION['item'.$i.'id'] = $_POST['item_id'];
					$_SESSION['item'.$i.'qty'] = $_POST['quantity'];
					$_SESSION['item'.$i.'total'] = $_POST['item_price'] * $_POST['quantity'];
					$_SESSION['item'.$i.'name'] = $_POST['item_name'];
					
					$_SESSION['total'] += $_POST['item_price'] * $_POST['quantity'];
					
					$_SESSION['items_count']++;
				}
				unset($_POST['add_item']);
			}
			$loggedIn = TRUE;
			$this->template->content = View::factory('shop/cart')
			->bind('loggedIn', $loggedIn);
		}
		else
		{
			/*
			 * Prompt login
			 */
			$loggedIn = FALSE;
			$this->template->content = View::factory('shop/cart')
			->bind('loggedIn', $loggedIn);
		}
	}
	public function action_success()
    {
    	//$_GET['token'] = $this->request->param('token','EC-2SR371543U941152F');
		//$_GET['PayerID'] = $this->request->param('PayerID','BF8VCDS8VGXGU');
		$_GET['token'] = Arr::get($_GET, 'token');
		$_GET['PayerID'] = Arr::get($_GET, 'PayerID');
		
		if(isset($_GET['token']) && !empty($_GET['token']) && isset($_SESSION['items_count'])) 
		{
			$paypal = new Paypal();
			$checkoutDetails = $paypal -> request('GetExpressCheckoutDetails', array('TOKEN' => $_GET['token']));
			
			// Complete the checkout transaction
			$requestParams = array(
			'TOKEN' => $_GET['token'],
			'PAYMENTACTION' => 'Sale',
			'PAYERID' => $_GET['PayerID'],
			'PAYMENTREQUEST_0_AMT' => $_SESSION['total'], // Same amount as in the original request
			'PAYMENTREQUEST_0_CURRENCYCODE' => 'SEK' // Same currency as the original request
			);
		
			$response = $paypal -> request('DoExpressCheckoutPayment',$requestParams);
			if( is_array($response) && $response['ACK'] == 'Success') 
			{ 
				// Payment successful
				// Fixa transationsid
				$transactionId = $response['PAYMENTINFO_0_TRANSACTIONID'];
				$msg = 'Köpet är genomfört!<br>';
				//$msg .= $transactionId;
				
				
				$receipt_text = "";
				$loggedInID = AUTH::Instance()->get_user()->id;
				$loggedInMail = AUTH::Instance()->get_user()->email;
				for ($i=0; $i < $_SESSION['items_count']; $i++) 
				{
					//TODO ordna upp så allt hamnar i 2 execute
					
					$item_qty = DB::select('quantity')->from('shop')->where('id','=',$_SESSION['item'.$i.'id'])->execute();
					//echo $item_qty[0]['quantity'] . ' - ' . $_SESSION['item'.$i.'qty'] . '<br>';
					$query = DB::update('shop')->set(array('quantity' => (intval($item_qty[0]['quantity']) - $_SESSION['item'.$i.'qty'])))->where('id', '=', $_SESSION['item'.$i.'id'])->execute();
					
					/* 
					 * Uppdater kvittotabellen
					 */
					$item_add = DB::insert('shop_receipt', array('id', 'userId', 'date', 'transactionToken', 'itemId', 'quantity', 'delivered'))->values(array('',$loggedInID, date('Y-m-d H:i:s'), $transactionId, $_SESSION['item'.$i.'id'], $_SESSION['item'.$i.'qty'], '0'))->execute();
					
					//Text kvitto
					$receipt_text .= '<h3>'.$_SESSION['item'.$i.'qty'] . ' x ' . $_SESSION['item'.$i.'name'].'</h3>';
				}
				$receipt_text .= "<h2>Totalt: $_SESSION[total] :-</h2>";
				session_unset(); 
				AUTH::Instance()->force_login($loggedInMail);
			}
			else
			{
				$msg = 'Köpet misslyckades!<br>';
			}
		}
		else
		{
			//header('Location: http://linda.mintcore.se/shop');
			header('Location: http://lindacarlstad.se/shop');
		}
		
        $this->template->content = View::factory('shop/success')
		->bind('response', $response)
		->bind('msg', $msg)
		->bind('tID', $transactionId)
		->bind('result', $result)
		->bind('text', $receipt_text);
    }

	public function action_itemStatus()
	{
		
		$strUsers = "";
		
		//För julsittningen
		$users = ORM::factory('user')->order_by('name')->find_all();
		$paid_users = DB::select('userId')->from('shop_receipt')->execute();
		foreach ($paid_users as $paid_user)
		{
			$temp = DB::select('name', 'surname')->from('users')->where('id', '=', $paid_user['userId'])->execute();		
			$strUsers .= $temp[0]['name'] . " " . $temp[0]['surname'] . "<br>";
			//$strUsers .= $users->where('id', '=', $paid_user['userId'])->find();
		}
		$this->template->content = View::factory('/shop/itemStatus')
		->bind('strUsers', $strUsers)
		;
		
		$this->assets(array(
			'css' => 'user/user_settings',
			'js' => 'user/user_settings',
		));
	}
	public function action_admin()
	{
		if(AUTH::Instance()->get_user() == NULL || !AUTH::Instance()->get_user()->has('roles', ORM::factory('role', array('name' => 'admin'))))
		{
			$this->request->redirect('/shop');
		}
		$users = ORM::factory('user')->order_by('name')->find_all();
		$joined_name = array(0 => '');
		foreach ($users as $user) 
		{
			$joined_name[$user->id] = "$user->name $user->surname";
		}
		
		
		
		$this->template->content = View::factory('/shop/admin')
		->bind('users', $users)
		->bind('joined_name', $joined_name)
		;
		
		$this->assets(array(
			'css' => 'user/user_settings',
			'js' => 'user/user_settings',
		));
	}
	
	public function action_admin_ajax()
	{
		$test = $_POST['receipt'];
		if (request::is_ajax())
		{
			
		}
	}
	public function action_cancelled()
    {
    	
        $this->template->content = View::factory('shop/cancelled');
    }
	
	public function action_destroy()
	{
		$this->template->content = View::factory('shop/destroy');
	}
}
