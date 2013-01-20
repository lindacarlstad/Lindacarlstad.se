<?php defined('SYSPATH') or die('No direct script access.'); ?>
			<section id="last-logged">
				<h3>Senast inloggade</h3>
				<ul>
<?php
	foreach($users as $user):
?>
					<li>
						<img src="/images/users/<?php echo $user->image; ?>.jpg" alt="<?php echo $user->full_name(); ?>" />
						<h4><a href="/user/profile/<?php echo $user->id; ?>"><?php echo $user->full_name(); ?></a></h4>
						<?php echo Test::time($user->last_login); ?>
					</li>
<?php
	endforeach;
?>
				</ul>
			</section>
