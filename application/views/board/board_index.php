<?php defined('SYSPATH') or die('No direct script access.'); ?>
		<h3>Styrelsen</h3>
		
		<p>Här presenteras vår styrelse, det är de som i huvudsak planerar våra aktiviteter och hjälper till med frågor om sitt område, om det är något just du undrar över, var inte rädd att kontakta någon i styrelsen om du har några förslag, funderingar eller andra frågor. Hittar du inte någon lämplig roll att kontakta kan du alltid kontakta vår ordförande.</p>
		
		<ul>
<?php
	foreach($boardmembers as $user):
?>
			<li>
				<article>
					<figure>
						<img src="/images/users/<?php echo $user->image; ?>.jpg" alt="<?php echo $user->name.' '.$user->surname; ?>" />
						<figcaption>
							<header>
								<hgroup>
									<h1><a href="/user/<?php echo $user->id; ?>/"><?php echo $user->name.' '.$user->surname; ?></a></h1>
									<h2><?php echo $user->title; ?></h2>
									<h6><?php echo HTML::mailto($user->titlemail); ?></h6>
								</hgroup>
							</header>
						</figcaption>
					</figure>
				</article>
			</li>
	
<?php
	endforeach;
?>
		</ul>