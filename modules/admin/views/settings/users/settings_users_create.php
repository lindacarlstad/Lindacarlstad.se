<?php defined('SYSPATH') or die('No direct script access.');?>

	<h2>Create user</h2>
	<form action="" method="post" class="half center">
		<fieldset>
			<legend>User credentials</legend>
<?php
	if(isset($errors)){
?>
			<ul class="errors">
<?php
		foreach($errors as $key => $error){
?>
				<li><?php echo $error; ?></li>
<?php
		}
?>
			</ul>
<?php
	}
?>
			<label for="name">Firstname *</label>
			<?php echo Form::input('name', $values['name'], array('id' => 'name', 'placeholder' => 'eg. Bill', 'required' => 'required')); ?>
			<label for="surname">Surname *</label>
			<?php echo Form::input('surname',  $values['surname'], array('id' => 'surname', 'placeholder' => 'eg. Mayer', 'required' => 'required')); ?>
			<label for="username">Username * <span>(used for login)</span></label>
			<?php echo Form::input('username',  $values['username'], array('id' => 'username', 'placeholder' => 'eg. bilmay', 'required' => 'required')); ?>
			<label for="email">Email address *</label>
			<?php echo Form::input('email',  $values['email'], array('type' => 'email','id' => 'username', 'placeholder' => 'eg. bill@mayer.com', 'required' => 'required')); ?>
		</fieldset>
		
		<fieldset>
			<legend>Roles</legend>
			<p>What roles and permissions will the new user have?</p>
			<ul class="checklist">
<?php
	$i = 0;
	foreach(ORM::Factory('role')->find_all() as $role){
	$checked = (in_array($role->id, Arr::get($values, 'roles', array()))) ? true : false;	
?>
				<li>
					<?php echo Form::checkbox('roles[]', $role->id, $checked, array('id' => 'role-'.$role->name)); ?>
					<label for="role-<?php echo $role->name; ?>"><?php echo ucfirst($role->name); ?></label>
					<p><?php echo $role->description; ?></p>
				</li>
<?php
	$i++;
	}
?>
			</ul>
		</fieldset>
		<button type="submit" name="submit" class="create">Create</button>
	</form>
