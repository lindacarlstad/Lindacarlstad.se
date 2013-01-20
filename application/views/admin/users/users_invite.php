<?php defined('SYSPATH') or die('No direct script access.'); ?>
		<nav id="admin-nav">
			<ul>
				<li class="active"><a href="/admin/users/">Användare</a></li>
				<li><a href="/admin/">-</a></li>
				<li><a href="/admin/">-</a></li>
				<li><a href="/admin/">-</a></li>
				<li><a href="/admin/">-</a></li>
			</ul>
		</nav>
		
		<nav id="admin-sub-nav">
			<ul>
				<li class="active"><a href="/admin/users/">Granska användare</a></li>
				<li><a href="/admin/users/invite/">Bjud in användare</a></li>
			</ul>
		</nav>
		
		<section id="admin-invite">
			<form action="" method="post">
				<div id="invite-content">

<?php
	for($i=0; count($values) > $i; $i++){
?>
					<div class="error">
					<?php echo Form::label('email', 'Email <span>'.$errors[$i]['email'].'</span>'); ?>
					
					<?php echo Form::input('email[]', $values[$i], array('id' => 'email', 'type' => 'email')); ?>
					
					</div>
<?php
	}
?>
					<div id="invite-inputs">
						<?php echo Form::label('email', 'Email'); ?>
						
						<?php echo Form::input('email[]', arr::get($values, 'email', NULL), array('id' => 'email', 'type' => 'email')); ?>
					</div>				
				</div>
				<button type="submit" name="submit" value="submit">Skicka invites</button>
			</form>
		</section>