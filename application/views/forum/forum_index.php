<?php defined('SYSPATH') or die('No direct script access.'); ?>
			<h1>Forumet</h1>
			
			
			<section id="filter">
				<form action="" method="post">
					<div>
						<input type="text" name="search" id="search" placeholder="Sök..." />
					<button type="submit" name="submit" value="submit">Filtrera</button>
					</div>
				</form>
				<?php
					if($user)
						//echo '<a href="/forum/add"><button>Skapa tråd</button></a>';
						//echo '<a href="/newstatusupdate/" id="create-new-status-update">Skapa uppdatering</a>';
				?>	
			</section>
			
			<section class="text" id="setcontent">
				<?php echo Request::factory('requests/feed/forums')->execute(); ?>
			</section>
