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
	
	<header id="header">
		<ul class="menu">
			<li<?php if($controller == 'home')echo ' class="active"';?>><a href="/admin/home/">Home</a></li>
			<li<?php if($controller == 'manage')echo ' class="active"';?>><a href="/admin/manage/">Manage</a></li>
			<li<?php if($controller == 'settings')echo ' class="active"';?>><a href="/admin/settings/">Global settings</a></li>
		</ul>
		<a id="logout" href="/admin/logout/">Logout</a>
		<a id="mintcore-logo" href="http://www.mintcore.se/">
			<img src="/layout/admin/mintcore-logo.png" alt="{mintcore}" />
		</a>
		
	</header>
		
	<section id="subnav">
		<ul id="hotlinks">
<?php
	$hotlinks = explode("/", $uri);
	$url = '/';
	foreach($hotlinks as $link){
		if(strlen($link) > 0){
			$url .= $link.'/';
?>
			<li><a href="<?php echo $url; ?>"><?php echo $link; ?></a></li>
<?php
		}
	}
?>
		</ul>
<?php
	if(count($subnav) > 0){
?>
		<ul id="specificnav">
<?php
		foreach($subnav as $title => $link){
?>
			<li><a<?php if($uri == $link){echo ' class="active"';} ?> href="<?php echo $link; ?>"><?php echo $title; ?></a></li>
<?php
		}
?>
	</ul>	
<?php
	}
?>
	</section>
	
	<section id="content">
		<?php echo $content; ?>
	</section>
	
	<footer id="footer">
		<p>copyright © {mintcore} 2011</p>
	</footer>
	<?php echo Assets::compile_js_framework()."\n\t".Assets::compile('js', $assets['js'], NULL, MODPATH.'admin/media/js/')."\n"; ?>
</body>