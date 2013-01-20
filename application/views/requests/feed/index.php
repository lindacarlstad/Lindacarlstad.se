<?php defined('SYSPATH') or die('No direct script access.'); 

	foreach($stories as $story){

		if(!empty($story->title)){
			$story = ORM::Factory('news', array('id' => $story->id));
			$type = 'news';
		}
		else {
			$story = ORM::Factory('forum', array('id' => $story->id));
			$type = 'forums';
		}
?>
		<article>
			<img src="/images/users/<?php echo $story->user->image ?>.jpg" alt="<?php echo $story->user->full_name(); ?>" title="<?php echo $story->user->full_name(); ?>" />
			<section>
				<header>
					<a href="/user/<?php echo $story->user->id; ?>/"><?php echo $story->user->full_name(); ?></a>
					<time title="<?php echo strftime("%A %e %B %R", $story->timestamp); ?>"><?php echo Date::fuzzy_span($story->timestamp); ?></time>
				</header>
				
				<a href="/forum/discuss/<?php echo $story->id; ?>/" class="discuss"><?php echo $story->comments->count_all(); ?></a>
				
				<div class="markup"><?php echo Markdown::instance()->transform(Text::limit_words($story->text, 25)); ?></div>
				
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
<?php
	}