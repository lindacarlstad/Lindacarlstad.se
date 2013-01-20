<?php defined('SYSPATH') or die('No direct script access.'); ?>
			<h3>Länkar</h3>
<?php
	if($user AND $user->is_not_a_slave()):
?>
			<div id="new-link">
<?php
		if($errors):
		var_dump($errors);
?>
			
<?php
		endif;
?>
				<form action="" method="post">
					<div>
						<?php echo Form::label('name', 'Namn'); ?>
						
						<?php echo Form::input('name', Arr::get($values, 'name', NULL), array('id' => 'name', 'placeholder' => 'mintcore')); ?>
					</div>
					
					<div>
						<?php echo Form::label('url', 'url'); ?>
						
						<?php echo Form::input('url', Arr::get($values, 'url', NULL), array('id' => 'url', 'placeholder' => 'http://blog.mintcore.se/', 'type' => 'url')); ?>
					</div>
					
					<div>
						<?php echo Form::label('linkcat_id', 'Typ'); ?>
						
						<?php echo Form::select('linkcat_id', $linktypes, Arr::get($values, 'linkcat_id', NULL), array('id' => 'linkcat_id'), 5); ?>
					</div>
					
					<div>
						<?php echo Form::label('text', 'Text'); ?>
						
						<?php echo Form::textarea('text', Arr::get($values, 'text', NULL), array('id' => 'text', 'placeholder' => 'blog.mintcore.se är Johan Tells blogg')); ?>
					</div>
					<button type="submit" name="submit" value="submit">Lägg till</button>
				</form>
			</div>
			<a href="#" id="new-link-toggle">Lägg till ny länk</a>
<?php
	endif;
?>			
			<ol>
<?php
	$current = FALSE;
	foreach($links as $link):
		if($current !== $link->category AND $current){
			$current = $link->category;
?>				
					</ol>
				</li>
				<li><?php echo $link->category; ?>
					<ol>
<?php
		}
		else if($current !== $link->category AND !$current){
			$current = $link->category;
?>
				<li><?php echo $link->category; ?>
					<ol>
<?php
		}
?>
						<li>
							<a href="<?php echo $link->url; ?>"><?php echo $link->name; ?></a>
							<p><?php echo $link->text; ?></p>
						</li>
<?php
	endforeach;
?>

					</ol>
				</li>
			</ol>