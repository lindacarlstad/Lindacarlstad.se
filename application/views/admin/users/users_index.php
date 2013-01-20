<?php defined('SYSPATH') or die('No direct script access.'); ?>
		<nav id="admin-nav">
			<ul>
				<li class="active"><a href="/admin/users/">Användare</a></li>
				<li><a href="/admin/">-</a></li>
				<li><a href="/admin/">-</a></li>
				<li><a href="/admin/">-</a></li>
				<li><a href="/admin/">-</a></li>
			</ul>
		</nav>
		
		<nav id="admin-sub-nav">
			<ul>
				<li class="active"><a href="/admin/users/">Granska användare</a></li>
				<li><a href="/admin/users/invite/">Bjud in användare</a></li>
			</ul>
		</nav>
		
		<table> 
			<caption>Användare (<?php echo count($users); ?>)</caption> 
			<thead> 
				<tr>
					<th class="image" scope="col"></th>
					<th scope="col">Namn</th>
					<th scope="col">Email</th>
					<th scope="col">Stad</th>
					<th scope="col">Registrerad</th>
				</tr> 
			</thead> 
			<tbody>
<?php
	foreach($users as $user):
?>
				<tr>
					<td><img src="/images/users/<?php echo $user->image; ?>.jpg" alt="<?php echo $user->full_name(); ?>" /></td>
					<td><?php echo $user->full_name(); ?></td>
					<td><?php echo $user->email; ?></td>
					<td><?php echo $user->city; ?></td>
					<td><?php echo date('Y', $user->joined); ?></td>
				</tr>
<?php
	endforeach;
?>
			</tbody> 
			<tfoot> 
				<tr> 
					<th class="image" scope="col"></th>
					<th scope="col">Namn</th>
					<th scope="col">Email</th>
					<th scope="col">Stad</th>
					<th scope="col">Registrerad</th>
				</tr> 
			</tfoot> 
		</table>