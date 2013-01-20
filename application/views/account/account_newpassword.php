<?php defined('SYSPATH') or die('No direct script access.'); ?>

<!DOCTYPE html> 
<html lang="se"> 
<head> 
	<meta charset="UTF-8" /> 
	
	<title>Linda Carlstad</title>  
	
	<meta name="viewport" content="width=device-width, initial-scale=1.0" /> 
	
	<?php echo Assets::compile('css', array('_vars', '_functions', 'globalMaster', 'globalStyle', 'globalLayout', 'account/account_signup')); ?>
		
	
 
</head> 
<body> 
	<canvas id="ambience" width="900" height="500"></canvas> 
	<header id="header"> 
		<figure> 
			<a href="/"><img src="/layout/logo.svg" width="100" height="80" alt="LINDA Carlstad" /></a> 
		</figure>
		
	<section id="main">
		<form action="/account/newpassword" method="post">
			<div>
				<h1>Ange ditt nya lösenord</h1>
				<br />
				Lösenord: <input type="password" name="pw" />
				Lösenord igen: <input type="password" name="pw_confirm" />
				<h5><?php echo $error ?></h5>
				<input type="hidden" name="token" value="<?php 
					echo $token		 
				 ?>">
				<button type="submit" name="submit" value="submit">Skicka</button>
			</div>
		</form>

	</section>

	<footer id="footer"> 
		<p>Copyright &copy; <a href="/">lindacarlstad.se</a> 2011. Alla rättigheter reserverade.</p> 
	</footer> 
 
</body> 
</html>