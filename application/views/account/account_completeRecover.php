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
		<p>Vidare instruktioner har skickats med e-post, kolla din inbox!</p>
		<form action="/start"><input type="submit" value="Tillbaka till startsidan"></form>
	</section>

	<footer id="footer"> 
		<p>Copyright &copy; <a href="/">lindacarlstad.se</a> 2011. Alla rättigheter reserverade.</p> 
	</footer> 
</body> 
</html>