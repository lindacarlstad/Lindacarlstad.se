<?php defined('SYSPATH') or die('No direct script access.'); ?>
		<header>
			<hgroup>
				<h1>Skapa nyhet</h1>
			</hgroup>
		</header>
		
		<div id="help-content">			
			<article class="markdown">
				<?php echo Markdown::instance()->transform(View::factory('docs/markdown')); ?>
			</article>			
		</div>
		
		<form action="" method="post">
			<button type="button" id="help-button">?</button>
			<?php echo Form::input('title', Arr::get($values, 'title'), array('id' => 'title', 'placeholder' => 'Titel')); ?>
			
			<?php echo Form::textarea('text', Arr::get($values, 'text'), array('id' => 'text', 'placeholder' => 'Text')); ?>
			<button type="submit" name="submit" value="submit">Skapa</button>
			
			<?php echo Form::input('tags', Arr::get($values, 'tags'), array('id' => 'tags', 'placeholder' => 'Taggar')); ?>
		</form>
		
		<div id="preview-content" class="markdown"></div>
