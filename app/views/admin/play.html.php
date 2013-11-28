<div class="row">
<?php
foreach($details as $detail){
?>
<div class="span5" style="border:1px solid black ">
	Username: <?=$detail['username']?>
	<form action="/API/Trade/<?=$detail['key']?>" method="post" target="_blank">
	<input type="hidden" name="nounce" value="<?=time()?>"><br>
	Type: <select name="type" class="span2">
	<option value="Buy">Buy</option>
	<option value="Sell">Sell</option>								
	</select><br>
	Pair: <select name="pair" class="span2">
	<?php foreach($trades as $trade){
		$FC = substr($trade['trade'],0,3);
		$SC = substr($trade['trade'],4,3);
		$FCB = $detail['balance.'.$FC];
		$SCB = $detail['balance.'.$SC];		
	?>
		<option value="<?=$FC?>_<?=$SC?>"><?=$FC?>(<?=$FCB?>)_<?=$SC?>(<?=$SCB?>)</option>
	<?php ??>
	</select><br>
	Amount: <input type="text" value="" placeholder="1.0" min="0.000001" max="9999" name="amount" id="amountBTC" class="span2" value="0.1"><br>
	Price: <input type="text" value="" placeholder="100.0" min="1" max="99999" name="price" id="PerPriceBTC" class="span2" ><br>
	<input type="submit" value="Trade" class="btn btn-primary">
	</form>
</div>
<?php }?>
</div>