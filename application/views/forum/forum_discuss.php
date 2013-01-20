<?php defined('SYSPATH') or die('No direct script access.'); ?>
			<article>
<?php
		if($user AND ($user->is_not_a_slave() OR $forum->user == $user)):
?>
				<ul class="manage">
					<li><a href="/forum/edit/<?php echo $forum->id; ?>/" class="edit"></a></li>
					<li><a href="/forum/delete/<?php echo $forum->id; ?>/" class="delete"></a></li>
				</ul>					
<?php
		endif;
?>
				<header>
					<time title="<?php echo strftime("%A %e %B %R", $forum->timestamp); ?>"><?php echo Date::fuzzy_span($forum->timestamp); ?></time> av <a href="/user/<?php echo $forum->user->id; ?>/"><?php echo $forum->user->full_name(); ?></a>.
					(<a class="comments" href="/news/story/<?php echo $forum->url; ?>/#comments"><?php echo $forum->comments->count_all(); ?> Kommentarer</a>)
				</header>
				<div class="markdown"><?php echo Markdown::instance()->transform($forum->text); ?></div>
			</article>
			
			<section id="comments">
				<h1>Kommentarer (<?php echo $forum->comments->count_all(); ?>)</h1>
				<section id="comments-content">
<?php
	foreach($forum->comments->find_all() as $comment){
?>
					<article>
						<img src="/images/users/<?php echo $comment->user->image ?>.jpg" alt="<?php echo $comment->user->name; ?>" title="<?php echo $comment->user->name.' '.$comment->user->surname; ?>" />
						<section>
							<header>
								<a href="/user/<?php echo $comment->user->id; ?>/"><?php echo $comment->user->full_name(); ?></a>
								<time title="<?php echo strftime("%A %e %B %R", $comment->timestamp); ?>"><?php echo Date::fuzzy_span($comment->timestamp); ?></time>
							</header>					
							<div><?php echo $comment->comment; ?></div>
<?php
	if($user){
?>
							<ul>
								<li><a class="reply" href="#" data-id="<?php echo $comment->id; ?>" data-name="<?php echo $comment->user->full_name(); ?>">reply</a></li>
							</ul>
<?php
	}
?>
						</section>			
					</article>

<?php
		foreach($comment->comments->find_all() as $reply){
?>
					<article class="reply">
						<img src="/images/users/<?php echo $reply->user->image ?>.jpg" alt="<?php echo $reply->user->name; ?>" title="<?php echo $reply->user->name.' '.$reply->user->surname; ?>" />
						<section>
							<header>
								<a href="/user/<?php echo $reply->user->id; ?>/"><?php echo $reply->user->full_name(); ?></a>
								<time title="<?php echo strftime("%A %e %B %R", $reply->timestamp); ?>"><?php echo Date::fuzzy_span($reply->timestamp); ?></time>
							</header>					
							<div><?php echo $reply->comment; ?></div>
<?php
	if($user){
?>
							<ul>
								<li><a class="reply" href="#" data-id="<?php echo $comment->id; ?>" data-name="<?php echo $comment->user->full_name(); ?>">reply</a></li>
							</ul>
<?php
	}
?>
						</section>			
					</article>
<?php
		}
	}
?>
				</section>
<?php
	if($user){
?>
				<section id="comment">
					<div id="reply-active-box"><span id="reply-to"></span><a href="#" id="cancel-reply" class="cancel">Avbryt</a></div>
					<form action="" method="post">
						<img src="/images/users/<?php echo $user->image; ?>.jpg" alt="<?php echo $user->full_name(); ?>" />
						<?php echo Form::textarea('comment', Arr::get($values, 'comment'), array('id' => 'comment', 'placeholder' => 'Kommentera')); ?>
						<input type="hidden" name="replies" id="reply-comment" />
						<button type="submit" name="submit" value="submit">Skicka</button>
					</form>
				</section>
<?php
	}
?>
			</section>