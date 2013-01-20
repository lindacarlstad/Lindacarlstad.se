<?php defined('SYSPATH') or die('No direct script access.'); ?>
<!DOCTYPE html>
<html lang="<?php echo $siteconfig->languagecode; ?>">
<head>
	<meta charset="UTF-8" />
	
	<title><?php echo (isset($title)) ? $siteconfig->sitename.' | '.$title : $siteconfig->sitename; ?></title>
	<meta name="description" content="<?php echo (isset($description)) ? $description : $siteconfig->description; ?>">
	<meta name="keywords" content="<?php echo (isset($keywords)) ? $kewords : $siteconfig->keywords; ?>" />
	<meta name="author" content="<?php echo (isset($author)) ? $author : 'Johan Tell, Mintcore'; ?>">

<?php
if(Request::user_agent('platform') == 'facebook'){
?>
	<meta property="og:title" content="<?php echo (isset($title)) ? $title : $siteconfig->sitename; ?>"/>
<?php
		if(isset($type)){ 
?>
	<meta property="og:type" content="'.$type.'"/>
<?php
		}
?>
	<meta property="og:image" content="<?php echo (isset($image)) ? $image : $siteconfig->logo; ?>"/>
	<meta property="og:site_name" content="<?php echo $siteconfig->sitename; ?>"/>
	<meta property="og:description" content="<?php echo (isset($description)) ? $description : $siteconfig->description; ?>"/>
<?php
}
?>	
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	
	<link rel="shortcut icon" href="/favicon.ico" />
	<link rel="apple-touch-icon" href="/apple-touch-icon.png" />
	
	<?php echo Assets::compile('css', array('under_construction')); ?>
	
	

</head>
<body>
	<header>

	</header>

	<section id="main" role="main">
	<h1>Under Construction</h1>
	</section>

	<footer>

	</footer>

<?php
	if(!empty($siteconfig->google_analytics_id))
	{
?>
	<script>var _gaq=[->_setAccount','<?php echo $siteconfig->google_analytics_id; ?>,->_trackPageview];(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];g.async=1;g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';s.parentNode.insertBefore(g,s)}(document,'script'));</script>
<?php 
	} 
?>
</body>
</html>