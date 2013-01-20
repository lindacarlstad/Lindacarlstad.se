<?php defined('SYSPATH') or die('No direct script access.'); ?>
		<header>
			<hgroup>
				<h1>Nytt på Linda Carlstad</h1>
			</hgroup>
			<ul class="buttonstack" id="feedfilter">
				<li><a href="/requests/feed/news/">Nyheter</a></li>
				<li><a class="active" href="/requests/feed/">Allt nytt</a></li>
			</ul>
		</header>
<?php
	if($user):
?>				
		<form action="/forum/add/" method="post" id="messageform">
			<textarea name="text" id="status-update-textarea" placeholder="Ditt meddelande" tabindex="1"><?php echo (isset($_POST['text'])) ? $_POST['text']: ''; ?></textarea>
			<button type="submit" name="submit" id="submit-messageform">Skapa</button>
			<input type="text" name="tags" id="tags-base" placeholder="Taggar separerade med ," tabindex="2" />
		</form>
		
		<a href="/newstatusupdate/" id="create-new-status-update">Skapa uppdatering</a>
		
<?php
	endif
?>
		
		<section class="text" id="setcontent">
			<?php echo Request::factory('requests/feed/')->execute(); ?>
		</section>
