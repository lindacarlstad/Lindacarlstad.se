<?php defined('SYSPATH') or die('No direct script access.');?>
			<h1>Om LINDA</h1>
			<div class="markdown">
<?php echo Markdown::instance()->transform($about->text); ?>
			</div>