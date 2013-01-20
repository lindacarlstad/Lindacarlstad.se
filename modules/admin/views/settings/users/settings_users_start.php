<?php defined('SYSPATH') or die('No direct script access.');?>

	<ul class="buttonstack">
		<li><a href="/admin/settings/users/create/"><img src="/layout/icons/small/user.png" alt="+" />Create new user</a></li>
	</ul>
	

	<form action="" method="post">
		<table>
			<caption>Users</caption>
			<thead>
				<tr>
					<th class="image" title="Image"></th>					
					<th>Username</th>
					<th>First name</th>
					<th>Surname</th>
					<th>Email address</th>
					<th>Roles</th>
					<th class="edit">Edit</th>
				</tr>
			</thead>
			<tbody>
<?php
	foreach($users as $user){
?>
			<tr>
				<td><img src="/images/users/<?php echo $user->image; ?>.jpg" alt="<?php echo $user->email; ?>" /></td>
				<td><?php echo $user->username; ?></td>
				<td><?php echo $user->name; ?></td>
				<td><?php echo $user->surname; ?></td>
				<td><?php echo $user->email; ?></td>
				<td><?php
			
	$first = true;
	foreach($user->roles->find_all() as $roles){
		if(!$first){echo ', ';}$first = false;
		
		echo $roles->name;	
	}			
			?></td>
				<td><a href="/admin/settings/users/edit/<?php echo $user->username; ?>/">Edit</a></td>
			</tr>
<?php
	}
?>
			</tbody>
			<tfoot>
				<tr>
					<th class="image" title="Image"></th>					
					<th>Username</th>
					<th>First name</th>
					<th>Surname</th>
					<th>Email address</th>
					<th>Roles</th>
					<th class="edit">Edit</th>
				</tr>
			</tfoot>
		</table>
	</form>