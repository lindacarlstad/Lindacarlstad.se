<?php defined('SYSPATH') or die('No direct script access.'); ?>
		<h2>Ändra kalenderevent</h2>
		<section id="calendar-new">		
			<form action="" method="post">
				<div id="new-event">
<?php
	if($errors){
		var_dump($errors);
	}
?>
					<div>
						<?php echo Form::label('title', 'Titel'); ?>
						
						<?php echo Form::input('title', Arr::get($values, 'title', NULL), array('id' => 'title', 'placeholder' => 'Styrelsemöte', 'required' => 'required')); ?>
						
					</div>
				
					<div>
						<?php echo Form::label('place', 'Plats'); ?>
						
						<?php echo Form::input('place', Arr::get($values, 'place', NULL), array('id' => 'place', 'placeholder' => 'KAU 21D403')); ?>
						
					</div>
					
					<div>
						<?php echo Form::label('eventtype', 'Typ av event'); ?>
						
						<?php echo Form::select('eventtype', $eventtypes, Arr::get($values, 'eventtype_id', 3), array('id' => 'eventtype'), 6); ?>
						
					</div>
					
					<div>
						<?php echo Form::label('date', 'Datum'); ?>
						
						<?php echo Form::input('date', Arr::get($values, 'date', NULL), array('id' => 'date', 'placeholder' => '14-05-2011', 'required' => 'required', 'class' => 'date', 'type' => 'date', 'pattern' => '[0-9]{2}-[0-9}{2}-[0-9]{4}')); ?>
						
						<?php echo Form::input('time', Arr::get($values, 'time', NULL), array('id' => 'time', 'placeholder' => '12:00', 'required' => 'required', 'class' => 'time', 'type' => 'time', 'pattern' => '[0-9]{2}:[0-9]{2}')); ?>
						
					</div>
					
					<div>
						<?php echo Form::label('date_end', 'Slutar?'); ?>
						
						<?php echo Form::input('date_end', Arr::get($values, 'date_end', NULL), array('id' => 'date_end', 'placeholder' => '14-05-2011', 'class' => 'date', 'type' => 'date', 'pattern' => '[0-9]{2}-[0-9}{2}-[0-9]{4}')); ?>
						
						<?php echo Form::input('time_end', Arr::get($values, 'time_end', NULL), array('id' => 'time_end', 'placeholder' => '12:00', 'class' => 'time', 'type' => 'time', 'pattern' => '[0-9]{2}:[0-9]{2}')); ?>				
						
					</div>
					
					<div>
						<?php echo Form::label('text', 'Beskrivning'); ?>
						
						<?php echo Form::textarea('text', Arr::get($values, 'text', NULL), array('id' => 'text')); ?>
						
					</div>
					<button type="submit" name="submit" value="submit">Spara</button>
				</div>
			</form>
		</section>