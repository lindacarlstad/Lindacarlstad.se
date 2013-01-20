<?php defined('SYSPATH') or die('No direct script access.');?>
	<h2>Settings</h2>
	<ul>
		<li><a href="/admin/settings/users/">Users</a></li>
<?php
	if($user->has('roles', ORM::factory('role', array('name' => 'developer')))){
?>
		<li><a href="/admin/settings/developer/">Developer settings</a></li>
<?php
	}
?>
	</ul>