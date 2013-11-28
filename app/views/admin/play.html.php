<div class="row">
<?php
foreach($details as $detail){
?>
<div class="span3" style="border:1px solid black ">
	Username: <?=$detail['username']?>
	<form action="/API/Trade/<?=$detail['key']?>" method="post" target="_blank">
	<input type="hidden" name="nounce" value="<?=time()?>"><br>
	Type: <select name="type" class="span2">
	<option value="Buy">Buy</option>
	<option value="Sell">Sell</option>								
	</select><br>
	Pair: <select name="pair" class="span2">
	<option value="BTC_USD">BTC_USD</option>
	<option value="BTC_GBP" selected="selected">BTC_GBP</option>
	<option value="BTC_EUR">BTC_EUR</option>
	<option value="BTC_LTC">BTC_LTC</option>				
	<option value="LTC_USD">LTC_USD</option>				
	<option value="LTC_EUR">LTC_EUR</option>				
	<option value="LTC_GBP">LTC_GBP</option>				
	</select><br>
	Amount: <input type="text" value="" placeholder="1.0" min="0.000001" max="9999" name="amount" id="amountBTC" class="span2" value="0.1"><br>
	Price: <input type="text" value="" placeholder="100.0" min="1" max="99999" name="price" id="PerPriceBTC" class="span2" ><br>
	<input type="submit" value="Trade" class="btn btn-primary">
	</form>
</div>
<?php }?>
</div>