<?php defined('SYSPATH') or die('No direct script access.'); ?>
		<header>
			<hgroup>
<?php
	if($user AND $user->is_not_a_slave()):
?>	
				<a class="add" href="/news/create/">Skapa nyhet</a>
<?php
	endif;
?>
				<h1>Nyheter</h1>				
			</hgroup>
		</header>
		
		<section id="articles">
<?php
	foreach($news as $story){
?>
			<article>
				<header>
					<hgroup>
						<h1><a href="/news/story/<?php echo $story->url; ?>/"><?php echo $story->title; ?></a></h1>
					</hgroup>
					<time title="<?php echo strftime("%A %e %B %R", $story->timestamp); ?>"><?php echo Date::fuzzy_span($story->timestamp); ?></time> av <a href="/user/<?php echo $story->user->id; ?>/"><?php echo $story->user->full_name(); ?></a>.
					(<a class="comments" href="/news/story/<?php echo $story->url; ?>/#comments"><?php echo $story->comments->count_all(); ?> Kommentarer</a>)
				</header>
				<div class="markdown"><?php echo Markdown::instance()->transform(Text::limit_words($story->text, 40)); ?></div>
				<a class="button" href="/news/story/<?php echo $story->url; ?>/">Fortsätt läsa</a>
			</article>
<?php
	}
?>
		</section>