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
		<h1>Glömt lösenord</h1>
		<p>Har du glömt ditt lösenord? Mata in din e-postadress så skickar vi en länk som hjälper dig.</p>

		<form action="/account/recover" method="post">
			<div>
				<input type="text" name="mail" />
				<h5><?php echo $error ?></h5>
				<button type="submit" name="submit" value="submit">Skicka</button>
			</div>
		</form>

	</section>

	<footer id="footer"> 
		<p>Copyright &copy; <a href="/">lindacarlstad.se</a> 2011. Alla rättigheter reserverade.</p> 
	</footer> 
 
</body> 
</html>