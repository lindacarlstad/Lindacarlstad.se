<?php defined('SYSPATH') or die('No direct script access.');?>

	<h2>Configure user roles</h2>
	
	<div class="split center">
	<table>
		<caption>User roles</caption>
		<thead>
			<tr>
				<th>Role</th>
				<th>Description</th>
			</tr>
		</thead>
		<tbody>
<?php
	foreach($roles as $role){
?>
			<tr>
				<td><?php echo ucfirst($role->name); ?></td>
				<td><?php echo ucfirst($role->description); ?></td>
			</tr>
<?php
	}
?>
		</tbody>
		<tfoot>
			<tr>
				<th>Role</th>
				<th>Description</th>
			</tr>
		</tfoot>
	</table>
	</div>