<?php defined('SYSPATH') OR die('No Direct Script Access');?>
<script>
	function populateReceipt()
	{
		$.ajax({
			type: 'POST',
			url:"/shop/admin_ajax",
			data: { 'receipt' : 'receipt_array'}
		});
		
		
		document.getElementById("receipt").innerHTML="<option value='test'>Test</option>";
	}
	function populateItem()
	{
	}
</script>


<h2>Redigera Shoppen</h2>
<h3>Kvitton</h3>
<fieldset>	
	<p>Ändring av kvitton:</p>
	<form action="" method="post">
		<label for="user" >
			<span>Användare:</span>
			
			<?php //http://www.geekgumbo.com/2011/06/26/kohana-3-orm-creating-a-form-select-list/
			echo Form::select('user', $joined_name, "", array("onchange='populateReceipt();'")); ?>
		</label>
		<label for="user_receipt">
			<span>Kvitto:</span>
			<select id="user_receipt">
				
			</select>
		</label>
		<label for="user_item">
			<span>Föremål:</span>
			<select id="user_item">
				
			</select>
		</label>
		<label for="user_date">
			<span>Datum:</span>
			2012-09-26 13:48
		</label>
		<label for="user_transactionToken">
			<span>Transaktionstoken:</span>
			0HU03716HX359383W
		</label>
		<label for="user_delivered">
			<span>Levererat:</span>
			<select id="user_delivered">
				<option value="0">Nej</option>
				<option value="1">Ja</option>
			</select>
		</label>
			<button type="submit" value="Spara" name="Spara">Spara</button>
			<button type="submit" value="Ta bort" name="Ta Bort">Ta bort</button>
	</form>
</fieldset>

<h3>Inventarier</h3>
<fieldset>	
	<form action="" method="post">
		<label for="item">
			<span>Föremål:</span>	
			<?php echo Form::select('user', ORM::factory('Shop')->order_by('name')->find_all()->as_array('id', 'name')); ?>
		</label>
		<label for="item_name">
			<span>Namn:</span>
			<?php //echo Form::input('item_name', $item->name); ?>
			<input type="text" />
		</label>
		<label for="item_price">
			<span>Pris:</span>
			<?php //echo Form::input('item_price', $item->price); ?>
			<input type="text" />
		</label>
		<label for="item_quantity">
			<span>Antal:</span>
			<?php //echo Form::input('item_price', $item->quantity); ?>
			<input type="text" />
		</label>
		<label for="item_choices">
			<button type="submit" value="add" name="add">Lägg Till</button>
			<button type="submit" value="alter" name="alter">Ändra</button>
			<button type="submit" value="remove" name="remove">Ta Bort</button>
		</label>
	</form>
</fieldset>

<h3>Betalat för sittningen</h3>
<fieldset>
	<?php echo $strUsers; ?>
</fieldset>