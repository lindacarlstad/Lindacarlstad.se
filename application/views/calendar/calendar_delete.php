<?php defined('SYSPATH') or die('No direct script access.'); ?>
			<div>
				<form action="" method="post">
					<p>Är du säker på att du vill radera detta event?</p>
					<div>
						<button type="submit" name="submit" class="delete" value="submit">Ja, radera</button>
						<a class="button" href="/calendar/event/<?php echo $event; ?>">Nej, gå tillbaka</a>
					</div>					
				</form>
			</div>