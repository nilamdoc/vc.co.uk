<form name="Admin_Hard" method="post" action="/Admin/hard" class="form-horizontal">
GBP:		<input type="text" name="withdrawal[GBP]" id="withdrawalGBP" placeholder="0" value="<?=$Withdrawal['withdrawal']['GBP']?>" class="span2"><br>

USD:		<input type="text" name="withdrawal[USD]" id="withdrawalUSD" placeholder="0" value="<?=$Withdrawal['withdrawal']['USD']?>" class="span2"><br>

EUR:		<input type="text" name="withdrawal[EUR]" id="withdrawalEUR" placeholder="0" value="<?=$Withdrawal['withdrawal']['EUR']?>" class="span2">		<br>

		<input type="submit" value="Save" class="btn btn-primary ">
</form>