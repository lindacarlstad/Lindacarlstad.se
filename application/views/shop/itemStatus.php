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

<h3>Betalat för sittningen</h3>
<fieldset>
	<?php echo $strUsers; ?>
</fieldset>