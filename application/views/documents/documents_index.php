<?php defined('SYSPATH') or die('No direct script access.');?>
			<h1>Dokument</h1>
<?php
	if($user AND $user->is_not_a_slave())
	{
?>
			<section id="new-document">
<?php
		if($errors){
		var_dump($errors);
		}
?>
				<form action="" enctype="multipart/form-data" method="post">
					<div>
						<?php echo Form::label('name', 'Namn'); ?>
					
						<?php echo Form::input('name', Arr::get($values, 'name', FALSE), array('id' => 'name', 'placeholder' => 'Styrelsemöte 27/7')); ?>
					</div>
					
					<div>
						<?php echo Form::label('file', 'Dokument'); ?>
						
						<?php echo Form::file('file', array('id' => 'file')); ?>
					</div>
					<button type="submit" name="submit" value="submit">Spara</button>
				</form>
			</section>
			<a href="#" id="new-document-toggle">Lägg till nytt dokument</a>
<?php
	}
?>
			<ul>
<?php
	foreach($documents as $document)
	{
?>
				<li>
					<article>
						<a href="/documents/download/<?php echo $document->url; ?>"><?php echo $document->name; ?></a>
						<p>.<?php echo $document->extension; ?></p>
<?php
	if($user AND $user->is_not_a_slave()):
?>
						<a class="delete" href="/documents/delete/<?php echo $document->url; ?>"><img src="/layout/icons/small/delete.png" alt="radera" /></a>
<?php
	endif;
?>
						<?php echo Test::time($document->timestamp); ?>
					</article>					
				</li>
<?php
	}
?>
			</ul>