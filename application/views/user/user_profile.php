<?php defined('SYSPATH') or die('No direct script access.'); ?>
		<section id="user-profile">
			<div>
				<figure>
					<img src="/images/users/<?php echo $user->image; ?>.jpg" alt="<?php echo $user->full_name(); ?>" />
				</figure>
			</div>
			<div>
				<h1><?php echo $user->full_name(); ?><?php echo (count($roles) > 0) ? '<span>'.implode(' & ', $roles).'</span>' : ''; ?></h1>
				<h2><?php echo $user->city; ?></h2>
				<dl>
					<div>					
						<dt>Födelsedag</dt>
							<dd><?php echo ($user->birthday) ? strftime("%e %B %G", $user->birthday) : '-'; ?></dd>
					</div>
					<div>					
						<dt>Syssla</dt>
							<dd><?php echo ($user->occupation) ? $user->occupation : '-'; ?></dd>
					</div>
					<div>					
						<dt>Medlem sedan</dt>
							<dd><?php echo strftime("%B %G", $user->joined); ?></dd>
					</div>
				</dl>
			</div>			
		</section>