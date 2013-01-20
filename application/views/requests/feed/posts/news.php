<?php defined('SYSPATH') or die('No direct script access.'); ?>
		<article class="news">
			<section>
				<header>
					<h1><a href="/news/story/<?php echo $story->url; ?>/"><?php echo $story->title; ?></a><a href="/news/story/<?php echo $story->url; ?>/#comments" class="comment"><?php echo $story->comments->count_all(); ?></a></h1>
					<time title="<?php echo strftime("%A %e %B %R", $story->timestamp); ?>"><?php echo Date::fuzzy_span($story->timestamp); ?></time>
					<span>by <a href="/user/<?php echo $story->user->id; ?>/"><?php echo $story->user->full_name(); ?></a></span>
				</header>
				
				<div class="markdown">
					<?php echo Markdown::instance()->transform(Text::limit_words($story->text, 50)); ?>
				</div>
				
<?php
		if($story->tags->count_all()){
?>
				<ul class="tags">
<?php	
			foreach($story->tags->find_all() as $tag){
?>
					<li><a href="/forum/bytag/<?php echo $tag->name; ?>/"><?php echo $tag->name; ?></a></li>
<?php
			}
?>
				</ul>
<?php
		}
?>				
				<a class="button" href="/news/story/<?php echo $story->url; ?>/">Fortsätt läsa</a>
			</section>			
		</article>
