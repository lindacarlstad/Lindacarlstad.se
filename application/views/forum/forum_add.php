<?php defined('SYSPATH') or die('No direct script access.'); ?>
		<div>
				<form action="" method="post">
					<fieldset>
						<label for="title">Titeln</label><br>
						<input name="title">
					</fieldset>
					<fieldset>
						<label for="text">Text</label><br>
						<textarea name="text" style="width: 550px; height: 100px;"></textarea>
					</fieldset>
					<fieldset>
						<label for="taggar">Taggar</label><br>
						<input name="tags" placeholder="Taggar separerade med ,">
					</fieldset>
					<button type="submit" name="submit" value="submit">Skapa tråd</button>
				</form>
		</div>