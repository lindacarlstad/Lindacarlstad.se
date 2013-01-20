<?php defined('SYSPATH') or die('No direct script access.'); ?>
		<article id="event">
<?php
		if($user AND $user->is_not_a_slave()):
?>
				<ul class="manage">
					<li><a href="/calendar/edit/<?php echo $event->id; ?>/" class="edit"></a></li>
					<li><a href="/calendar/delete/<?php echo $event->id; ?>/" class="delete"></a></li>
				</ul>					
<?php
		endif;
?>
			<header>
				<hgroup>
					<h1><?php echo $event->title; ?></h1>
					<h6><?php echo $event->place; ?></h6>
				</hgroup>
				<time><?php echo Test::time($event->timestamp, $event->timestamp_ends, FALSE); ?></time>
			</header>
			<section id="event-content" class="markdown">
				<?php echo Markdown::instance()->transform($event->text); ?>
			</section>
		</article>