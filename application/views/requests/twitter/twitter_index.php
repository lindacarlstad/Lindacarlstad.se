<?php defined('SYSPATH') or die('No direct script access.');?>

<section id="twitter">
			<h3>Twitter</h3>
<?php
	foreach($feed as $tweet):
?>
			<div class="twitter-tweet">
				<h6><a href="<?php echo $tweet->user->url; ?>">@<?php echo $tweet->user->screen_name; ?></a></h6>
				<p><?php echo Text::twitter_linkify($tweet->text); ?></p>
				<?php echo Test::time(strtotime($tweet->created_at)); ?>
			</div>
<?php
	endforeach;
?>
		</section>