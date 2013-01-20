<?php defined('SYSPATH') or die('No direct script access.'); ?>
		<article>
			<img class="userimage" src="/images/users/<?php echo $story->user->image ?>.jpg" alt="<?php echo $story->user->full_name(); ?>" title="<?php echo $story->user->full_name(); ?>" />
			<section>
				<header>
					<a href="/user/<?php echo $story->user->id; ?>/"><?php echo $story->user->full_name(); ?></a>
					Via <a href="/forum/">forumet</a>
					<time title="<?php echo strftime("%A %e %B %R", $story->timestamp); ?>"><?php echo Date::fuzzy_span($story->timestamp); ?></time>
				</header>
				
				<a href="/forum/discuss/<?php echo $story->id; ?>/" class="discuss"><?php echo $story->comments->count_all(); ?></a>
				
				<div class="markup"><?php echo Markdown::instance()->transform(Text::limit_words($story->text, 100, '… [[Läs mer]](/forums/discuss/'.$story->id.')')); ?></div>
				
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
			</section>			
		</article>
