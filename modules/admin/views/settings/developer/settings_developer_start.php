<?php defined('SYSPATH') or die('No direct script access.');?>
		<h2>Developer settings</h2>
		
		<form action="" method="post" class="half center">
			<fieldset>
				<legend>Global settings</legend>
				<ul class="checklist">
					<li>
						<input type="checkbox" name="under_construction" id="under_construction"<?php echo (Arr::get($settings, 'under_construction')) ? ' checked="checked"' : ''; ?> />
						<label for="under_construction">Under Construction</label>
						<p>Sets the site to construction mode: will redirect all users to a "under construction" page.</p>
					</li>
				</ul>
			</fieldset>
			<button name="submit" type="submit" class="save">Save</button>
		</form>