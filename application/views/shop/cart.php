<?php defined('SYSPATH') OR die('No Direct Script Access');?>
<?php
	//Dirigera till paypal
	if (isset($_POST['redirect']) && !empty($_POST['redirect']) && $_POST['redirect'] == 'redirect')
	{
		//require_once("paypal.php");
		/*$requestParams = array(
		   'RETURNURL' => 'http://linda.mintcore.se/shop/success',
		   'CANCELURL' => 'http://linda.mintcore.se/shop/cancelled'
		);*/
		$requestParams = array(
		   'RETURNURL' => 'http://lindacarlstad.se/shop/success',
		   'CANCELURL' => 'http://lindacarlstad.se/shop/cancelled'
		);
		
		$orderParams = array(	
		   'PAYMENTREQUEST_0_AMT' => urlencode($_SESSION['total']),
		   'PAYMENTREQUEST_0_SHIPPINGAMT' => '0',
		   'PAYMENTREQUEST_0_CURRENCYCODE' => 'SEK',
		   'PAYMENTREQUEST_0_ITEMAMT' => urlencode($_SESSION['total'])
		);
		$items = array();
		for ($i = 0; $i < $_SESSION['items_count']; $i++)
		{
			$item = array(
			   "L_PAYMENTREQUEST_0_NAME".$i => $_SESSION['item'.$i.'name'],
			   "L_PAYMENTREQUEST_0_AMT".$i => $_SESSION['item'.$i.'total']/$_SESSION['item'.$i.'qty'],
			   "L_PAYMENTREQUEST_0_QTY".$i => $_SESSION['item'.$i.'qty']
			);
			$items = array_merge($items, $item); 
		}
		
		$paypal = new Paypal();
		$response = $paypal -> request('SetExpressCheckout',$requestParams + $orderParams + $items + array("SOLUTIONTYPE" => 'Sole'));
	
		if(is_array($response) && $response['ACK'] == 'Success') 
		{ //Request successful
	      $token = $response['TOKEN'];
	      //header( 'Location: https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&token=' . urlencode($token) );
		  header( 'Location: https://www.paypal.com/webscr?cmd=_express-checkout&token=' . urlencode($token) );
		}
		/*
		echo "$response";
		print_r($response);
		echo $items;
		print_r($items);
		 */
	}
	//Kod för att uppdatera Quantity
	if (isset($_POST['newQty']) && !empty($_POST['newQty']) && $_POST['newQty'] == 'newQty')
	{
		for ($i = 0; $i < $_SESSION['items_count']; $i++)
		{
			if ($_SESSION['item'.$i.'qty'] != $_POST['newQty'.$i])
			{
				if ($_POST['newQty'.$i] == 0)
				{
					$_SESSION['items_count']--;
					for ($j = $i; $j < $_SESSION['items_count']; $j++)
					{
						$_SESSION['item'.$j.'id'] = $_SESSION['item'.($j+1).'id'];		
						$_SESSION['item'.$j.'qty'] = $_SESSION['item'.($j+1).'qty']; 
						$_SESSION['item'.$j.'total'] = $_SESSION['item'.($j+1).'total'];
						$_SESSION['item'.$j.'name'] = $_SESSION['item'.($j+1).'name']; 	
						$_POST['newQty'.$j] = $_POST['newQty'.($j+1)];
					}
					unset($_SESSION['item'.$j.'id']);
					unset($_SESSION['item'.$j.'qty']);
					unset($_SESSION['item'.$j.'total']);
					unset($_SESSION['item'.$j.'name']);
					$i--;
				}
				else
				{
					$old_total = $_SESSION['item'.$i.'total']; 
					$_SESSION['item'.$i.'total'] = ($old_total/$_SESSION['item'.$i.'qty']) * $_POST['newQty'.$i];
					$_SESSION['total'] -= $old_total;
					$_SESSION['total'] += $_SESSION['item'.$i.'total'];
					$_SESSION['item'.$i.'qty'] = $_POST['newQty'.$i];
				}
			}
		}
	}

	if (isset($_SESSION['items_count']) && $_SESSION['items_count'] > 0 && $loggedIn == TRUE)
	{
		$_SESSION['total'] = 0;
		echo "<h2>Produkter:</h2>
			  <form method='post' action=''>";
		for ($i=0; $i < $_SESSION['items_count']; $i++) 
		{
			echo "<h1><input type='text' size='1' maxlength='2' name='newQty$i' value=".$_SESSION['item'.$i.'qty'].">";
			echo ' x ' . $_SESSION['item'.$i.'name'].'</h1><br>';
			$_SESSION['total'] += $_SESSION['item'.$i.'total']; 
		}
		echo "
				<input type='hidden' name='newQty' value='newQty'>
				<input type='submit' value='Uppdatera'/>
				</form>
				<h2>Summa:</h2><h1>" . $_SESSION['total'] . " kr  </h1>
				<form method='POST' action='' style='float:left; margin-right: 3em;'>
			 	<input type=image src='https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif' name=METHOD value=SetExpressCheckout>
			 	<input type=hidden name='redirect' value='redirect'>
				</form>
				<form method='post' action='/shop'>
					<input type='submit' value='Tillbaka'>
				</form>
				<br>
				<p><h4>Det går att betala med paypal utan konto, klicka bara på 'Don't have a PayPal Account?' (se <a href='/images/shop/pp1.png' style='color: blue;'>bild</a>).</h4></p>
				<p><h4>Om du köper sittningsbiljett eller nollningsmedlemskap till någon annan än dig själv ska detta noteras under paypal betalningen (se <a href='/images/shop/pp.png' style='color: blue;'>bild</a> ).</h4></p>
		";
	}
	elseif ($loggedIn == FALSE)
	{
		echo "Var god och logga in!";
	}
	else
	{
		echo "Kundvagnen är tom!<br><form method='post' action='/shop'>
			<input type='submit' value='Till webbutiken'>
			</form>";
	}
?>