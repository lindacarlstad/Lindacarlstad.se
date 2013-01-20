<?php defined('SYSPATH') or die('No direct script access.'); ?>
			<div>
				<form action="" method="post">
					<label for="text">Text</label>
					<textarea name="text" required><?php echo $forum->text; ?></textarea>
					<button type="submit" name="submit" value="submit">Spara</button>
				</form>
			</div>