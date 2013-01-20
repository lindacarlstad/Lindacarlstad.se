<?php defined('SYSPATH') or die('No direct script access.');?>
		<h2>Welcome <?php echo $user->name; ?></h2>

<h2>Teststrings</h2>
<h2>This is a table</h2>
<table>
<caption>CSS3 Color Units</caption>
<thead>
<tr>
<th class="units" scope="col">Unit</th>
<th class="core21" scope="col">Presto 2.1</th>
<th class="core22 active" scope="col">Presto 2.2 +</th>
<th class="webkit" scope="col">WebKit 3</th>
<th class="gecko" scope="col">Gecko 1.9</th>
<th class="trident" scope="col">Trident</th>
</tr>
</thead>
<tbody>
<tr>
<td>HTML Colour keywords</td>
<td class="yes">Yes</td>
<td class="yes">Yes</td>
<td class="yes">Yes</td>
<td class="yes">Yes</td>
<td class="yes">Yes</td>
</tr>
<tr>
<td>SVG Colour keywords</td>
<td class="yes">Yes</td>
<td class="yes">Yes</td>
<td class="yes">Yes</td>
<td class="yes">Yes</td>
<td class="yes">Yes‡</td>
</tr>
<tr>
<td>RGB</td>
<td class="yes">Yes</td>
<td class="yes">Yes</td>
<td class="yes">Yes†</td>
<td class="yes">Yes</td>
<td class="yes">Yes</td>
</tr>
<tr>
<td>RGBA</td>
<td class="no">No</td>
<td class="yes">Yes</td>
<td class="yes">Yes†</td>
<td class="yes">Yes</td>
<td class="no">No</td>
</tr>
<tr>
<td>HSL</td>
<td class="yes">Yes</td>
<td class="yes">Yes</td>
<td class="yes">Yes</td>
<td class="yes">Yes</td>
<td class="no">No</td>
</tr>
<tr>
<td>HSLA</td>
<td class="no">No</td>
<td class="yes">Yes</td>
<td class="yes">Yes</td>
<td class="yes">Yes</td>
<td class="no">No</td>
</tr>
<tr>
<td>transparent</td>
<td class="yes">Yes**</td>
<td class="yes">Yes</td>
<td class="yes">Yes</td>
<td class="yes">Yes</td>
<td class="yes">Yes**</td>
</tr>
<tr>
<td>currentColor</td>
<td class="yes">Yes</td>
<td class="yes">Yes</td>
<td class="no">No</td>
<td class="yes">Yes</td>
<td class="no">No</td>
</tr>
</tbody>
<tfoot>
<tr>
<th class="units" scope="col">Unit</th>
<th class="core21" scope="col">Presto 2.1</th>
<th class="core22 active" scope="col">Presto 2.2 +</th>
<th class="webkit" scope="col">WebKit 3</th>
<th class="gecko" scope="col">Gecko 1.9</th>
<th class="trident" scope="col">Trident</th>
</tr>
</tfoot>
</table>

<h2>Table with edit and remove</h2>

<table>
	<caption>Users</caption>
	
	<thead>
		<tr>
			<th class="edit" scope="col">Edit</th>
			<th scope="col">Name</th>
			<th scope="col">Email</th>
			<th class="delete" scope="col">Delete</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td><a href="#">edit</a></td>
			<td>Johan Tell</td>
			<td>johan@mintcore.se</td>
			<td><a href="#">delete</a></td>
		</tr>
	</tbody>
	<tfoot>
		<tr>
			<th class="edit" scope="col">Edit</th>
			<th scope="col">Name</th>
			<th scope="col">Email</th>
			<th class="delete" scope="col">Delete</th>
		</tr>
	</tfoot>
</table>
		<div class="split">
			<h3>This is a button</h3>
			<div class="notification">35</div>
			<a class="button" href="http://www.mintcore.se/">Mintcore</a>
		</div>		
		<div class="split">
			<h4>This is a buttonstack</h4>
			<ul class="buttonstack">
				<li><div class="notification">35 pages only</div><a href="#">button one</a></li>
				<li><a class="active" href="#">button two</a></li>
				<li><a href="#">button three</a></li>
				<li><a href="#">button four</a></li>
			</ul>
		</div>
		
		<h5>This is a form</h5>
		<form class="half">
			<fieldset>
				<legend>A regular form</legend>
				<label for="name">Your name</label>
				<input type="text" id="name" name="name" placeholder="eg. Johan Tell" />
				<label for="age">Your age</label>
				<select name="age" id="age">
					<option value="20">20</option>
					<option value="19">19</option>
				</select>
				<label for="email">Your email</label>
				<input type="email" id="email" name="email" placeholder="eg. johan@mintcore.se" />
				<label for="about">About you</label>
				<textarea name="about" id="about" placeholder="Hello! I'm..."></textarea>
				<button name="submit" class="submit">Save</button>
			</fieldset>
		</form>

