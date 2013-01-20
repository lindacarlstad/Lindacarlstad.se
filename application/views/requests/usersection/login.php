<?php defined('SYSPATH') or die('No direct script access.'); ?>
			<section id="usersection">
				<h2>Logga in</h2>
				<form action="" method="post">
					<?php echo Form::label('email', 'Email'); ?>
					
					<?php echo Form::input('email', Arr::get($_POST, 'email'), array('id' => 'email', 'type' => 'email')); ?>
					
					<?php echo Form::label('password', 'Lösenord'); ?>
				
					<?php echo Form::password('password', null, array('id' => 'password')); ?>
				
					<?php echo Form::checkbox('remember', Arr::get($_POST, 'remember'), FALSE,  array('id' => 'remember')); ?>
				
					<?php echo Form::label('remember', 'Kom ihåg mig'); ?>
				
					<button type="submit" name="login">Logga in</button>
				</form>
			</section>
