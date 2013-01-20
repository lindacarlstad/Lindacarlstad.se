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
	<meta property="og:type" content="<?php echo $type ; ?>"/>
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
	
	<?php echo Assets::compile('css', $assets['css']); ?>
	
	

</head>
<body>
	<canvas id="ambience" width="900" height="500"></canvas>
	<header id="header">
		<figure>
			<a href="/"><img src="<?php echo $siteconfig->logo; ?>" width="100" height="80" alt="LINDA Carlstad" /></a>
		</figure>
		<nav>
			<ul>
				<li><a href="/news/">Nyheter</a></li>
				<li><a href="/forum/">Forum</a></li>
				<li><a href="/shop/">Shop</a></li>
				<li><a href="/about/">Om LINDA</a></li>
				<li><a href="/board/">Styrelsen</a></li>
				<li><a href="/documents/">Dokument</a></li>
				<li><a href="/irc/">Chatt</a></li>
				<li><a href="/links/">Länkar</a></li>
<?php
	if($user AND $user->is_admin()){
?>
				<li><a href="/admin/">Admin</a></li>
<?php	
	}
?>
			</ul>
		</nav>
	</header>

	<section id="main" role="main">
		<section id="left">
<?php
	if($user)
	{
 		echo Request::factory('requests_usersection/usersection')->execute();
	}
	else
	{
		if(isset($loginerrors))
		{
			var_dump($loginerrors);
		}
		echo Request::factory('requests_usersection/login')->execute();
	}
?>		

<?php
	if(!$user):
?>			
		<div>
			<a href="/register/" class="not-member">Bli medlem</a>
		</div>
		<div>
			<a href="/account/recover" class="not-member">Glömt lösenord?</a>
		</div>
<?php
	endif;
?>

		<div style="color:red;">
			<p>Hittar ni några buggar eller något som känns jävligt dumt, lägg till det via formuläret på startsidan!</p>
		</div>
		
<?php
	if($user)
	{
		echo Request::factory('requests_usersection/lastlogged')->execute();
	}
?>

		</section>
		
		<section id="middle">
<?php echo $content; ?>		
		</section>
		
		<section id="right">
			<section id="calendar">
				<?php echo Request::factory('requests/calendar')->execute(); ?>
			</section>
			</section>
				<section id="calendar-bottom">
				<ul>
<?php
	if($user AND $user->is_not_a_slave()){
?>
					<li><a href="/calendar/new/" class="add" title="Lägg till"></a></li>
<?php	
	}
?>
					<li><a href="/calendar/export/" id="export-calendar" class="export" title="Export"></a></li>
					<li><a class="calendarlink" href="/ajax/calendar/<?php echo Date("n/Y", time()); ?>/">Till idag</a></li>
				</ul>
				
				<div id="export-calendar-holder">
					<h3>Exportera kalendern</h3>
					<p>Du kan exportera din kalender till iCal eller google calendar genom att prenumerera på följande länk:</p>
					<input type="text" value="http://lindacarlstad.se/export/calendar/" class="copy-me" />
					<p>Glöm inte att manuellt ställa in så den uppdateras så ofta som möjligt!</p>
				</div>
				
			</section>
			
			<?php echo Request::factory('requests/calendar/list/')->execute(); ?>
			
			<?php echo Request::factory('requests/twitter/index/')->execute(); ?>
			
		</section>
	</section>

	<footer id="footer">
		<p>Copyright &copy; <a href="/">lindacarlstad.se</a> <?php echo ($siteconfig->releaseyear < date('Y')) ? $siteconfig->releaseyear.' - '.date('Y') : $siteconfig->releaseyear; ?>. Alla rättigheter reserverade.</p>
	</footer>

	<?php echo Assets::compile_js_framework()."\n\t".Assets::compile('js', $assets['js']); ?>

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