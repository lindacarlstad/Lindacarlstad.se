<?php defined('SYSPATH') or die('No direct script access.');?>
<!doctype html>  
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge;chrome=1" >
	<meta charset="utf-8">

	<title  dir="ltr"><?php echo $siteconfig->name; if(isset($title)){echo ' - '.$title;} ?></title>
  
	<meta name="keywords" content="<?php echo $siteconfig->keywords; ?>">
	<meta name="description" content="<?php echo $siteconfig->keywords; ?>">
  	<meta name="viewport" content="width=device-width, initial-scale=1.0">  

  	<link rel="shortcut icon" href="favicon.png" >
  	<link rel="apple-touch-icon" href="//html5boilerplate.com/apple-touch-icon.png"> 

	<?php echo Assets::compile('css', $assets['css'], NULL, MODPATH.'admin/media/less/')."\n"; ?>
</head>
<body>
			
	<section id="content">
		<section id="login">
			<h2>Logga in</h2>
<?php
if($errors){
	var_dump($errors);
?>
			<p class="error">Ogiltlig kombination av användarnamn och lösenord.</p>
<?php			
} 
?>
			<form action="" method="post">
				<input type="text" name="username" placeholder="Användarnamn" />
				<input type="password" name="password" placeholder="Lösenord" />
				<button type="submit" name="login" class="submit">Logga in</button>
			</form>
			<ul>
				<li><a href="/admin/newpassword/">Glömt lösenord?</a></li>
			</ul>
		</section>		
	</section>
	
	<footer id="footer">
		<p>copyright © {mintcore} 2011</p>
	</footer>
	<?php echo Assets::compile_js_framework()."\n\t".Assets::compile('js', $assets['js'], NULL, MODPATH.'admin/media/js/')."\n"; ?>
</body>