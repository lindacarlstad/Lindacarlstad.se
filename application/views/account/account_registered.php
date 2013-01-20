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
		<h1>Välkommen till Lindacarlstad <?php echo $user->name; ?></h1>
		<p>Du är nu registrerad och automatiskt inloggad! glöm inte att kolla in dina inställningar det första du gör!</p>
		<a class="button" href="/user/settings/">Till inställningar</a>
	</section>

	<footer id="footer"> 
		<p>Copyright &copy; <a href="/">lindacarlstad.se</a> 2011. Alla rättigheter reserverade.</p> 
	</footer> 
 
	<?php echo Assets::compile_js_framework()."\n\t".Assets::compile('js', array('globalCode', 'signup')); ?>
	
</body> 
</html>