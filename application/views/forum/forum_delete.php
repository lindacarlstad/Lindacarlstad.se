<?php defined('SYSPATH') or die('No direct script access.'); ?>
			<div>
				<form action="" method="post">
					<p>Är du säker på att du vill radera detta inlägg?</p>
					<div>
						<button type="submit" name="submit" class="delete" value="submit">Ja, radera</button>
						<a class="button" href="/forum/discuss/<?php echo $id; ?>">Nej, gå tillbaka</a>
					</div>					
				</form>
			</div>