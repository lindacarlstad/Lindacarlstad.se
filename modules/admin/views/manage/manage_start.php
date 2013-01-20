<?php defined('SYSPATH') or die('No direct script access.');?>
<h2>Manage</h2>
	<div class="holder">
<?php
	$i = 0;
	foreach($structure as $section => $items){
?>
		<ul>
			<li><h3><?php echo $section; ?></h3></li>
<?php
		foreach($items as $item => $href){
?>
			<li><a href="/admin/manage/<?php echo $href; ?>"><?php echo $item; ?></a></li>
<?php
		}
?>
		</ul>
<?php
	if($i % 3 == 2){
?>
	</div>
	<div class="holder">
<?php
	}
	$i++;
	}
?>
	</div>
