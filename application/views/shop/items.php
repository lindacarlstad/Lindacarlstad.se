<?php defined('SYSPATH') or die('No direct script access.');?>
<?php
	foreach($items as $item)
	{
		/* Glömt bort vad det här var bra för :p
		$extra = '';
		if ($item['id']%2 == 0)
		{
			$extra = '';
		}
		echo "<div style='$extra'>";
		 
		 */
	    echo "<fieldset><label>$item[name]</label><br>";
		if (isset($item['img_src'])) echo "<img src='/images/shop/$item[img_src]' style='width:150px; height:150px; display:block;'>";
		
		
		if ($item['quantity'] > 0)
		{
    		echo "<form action='/shop/cart' method='post'> 	    				
					<span>Antal: (Lagerstatus: $item[quantity])</span><br>
	    			<input type='text' name='quantity' size='3' value='1'> x $item[price] kr<br>
	    			<input type='hidden' name='item_id' value='$item[id]'>
	    			<input type='hidden' name='item_name' value='$item[name]'>
	    			<input type='hidden' name='item_price' value='$item[price]'>
	    			<input type='hidden' name='add_item' value='true'>
    				<input type='submit' value='Lägg till'>
				</form><br>";
		}
		else
		{
			echo "<span>Antal: (Lagerstatus: SLUT)</span>";
		}
		echo "</fieldset>";
		//echo '</div><br>';
		echo '<br>';
	}
?>
<form action="/shop/cart" method="post">
	<input type="submit" value="Gå till kassan">
</form>
<form action="shop/destroy" method="post">
	<input type="submit" value="Töm kundvagnen">
</form>
