<?php defined('SYSPATH') or die('No direct script access.');?>
<section id="calendar-list">
<?php
	if($current_events->count() > 0):
?>
				<h3>Pågår just nu</h3>
				<ul>
<?php
			foreach($current_events as $event):
?>
					<li>
						<a href="/calendar/event/<?php echo $event->id; ?>/"><?php echo $event->title; ?></a>
						<p><?php echo $event->place; ?></p>
						<?php echo Test::time($event->timestamp, $event->timestamp_ends); ?>
					
						</li>
<?php
			endforeach;
?>
				</ul>
<?php	
	endif;
?>
				<h3>Kommande händelser</h3>
<?php
	if(count($events) > 0)
	{
?>

				<ul>
<?php
		foreach($events as $event)
		{
?>
					<li>
						<a href="/calendar/event/<?php echo $event->id; ?>/"><?php echo $event->title; ?></a>
						<p><?php echo $event->place; ?></p>
						<?php echo Test::time($event->timestamp, $event->timestamp_ends); ?>
					
						</li>
<?php
		}
?>
				</ul>
<?php	
	}
	else
	{
?>
				<p><em>Inga event inom de närmsta 60 dagarna.</em></p>
<?php
	}
?>
			</section>