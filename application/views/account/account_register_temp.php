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
		<h1>Registrering</h1>
		<p>Ett medlemskap i LINDA kostar 300SEK och håller livet ut! Det ger dig möjligthet att deltaga på LINDA's många och roliga tillställningar! För att registrera dig fyllar du enkelt i informationen om dig nedan och genomför betalningen till oss!</p>
		<form action="signup" method="post">
			<div>
<?php
	if($errors){
		echo Debug::vars($errors);
	}
?>
				<?php echo Form::label('email', 'Email'); ?>
				
				<?php echo Form::input('email', Arr::get($values, 'email', NULL), array('id' => 'email', 'type' => 'email')); ?>
				
				<?php echo Form::label('name', 'Förnamn'); ?>
				
				<?php echo Form::input('name', Arr::get($values, 'name', NULL), array('id' => 'name')); ?>
				
				<?php echo Form::label('surname', 'Efternamn'); ?>
				
				<?php echo Form::input('surname', Arr::get($values, 'surname', NULL), array('id' => 'surname')); ?>
				
				<?php echo Form::label('password', 'Lösenord'); ?>
				
				<?php echo Form::password('password', NULL, array('id' => 'password')); ?>
				
				<?php echo Form::label('password_confirm', 'Upprepa lösenord'); ?>
				
				<?php echo Form::password('password_confirm', NULL, array('id' => 'password')); ?>
				
				<button type="submit" name="submit" value="submit">Spara</button>
			</div>
		</form>
	</section>

	<footer id="footer"> 
		<p>Copyright &copy; <a href="/">lindacarlstad.se</a> 2011. Alla rättigheter reserverade.</p> 
	</footer> 
 
	<?php echo Assets::compile_js_framework()."\n\t".Assets::compile('js', array('globalCode', 'signup')); ?>
	
</body> 
</html>