<?php defined('SYSPATH') or die('No direct script access.'); ?>
		<section id="usersection">
			<figure>
				<img src="/images/users/<?php echo $user->image; ?>.jpg" alt="<?php echo $user->name.' '.$user->surname; ?>" />
			</figure>
			<h1>Hej <?php echo $user->name; ?>!</h1>
			<nav>
				<ul>
					<li><a href="/user/">Min profil</a></li>
					<li><a href="/user/settings">Mina inställningar</a></li>
					<li><a href="/user/inbox/">Meddelanden</a></li>
					<li><a href="/logout/">Logga ut</a></li>
				</ul>
			</nav>
		</section>