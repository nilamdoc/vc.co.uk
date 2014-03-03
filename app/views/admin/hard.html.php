<form name="Admin_Hard" method="post" action="/Admin/hard" class="form-horizontal">
		<input type="text" name="withdrawal.GBP" id="withdrawal.GBP" placeholder="0" value="<?=$Withdrawal['withdrawal']['GBP']?>" class="span2">
		<input type="text" name="withdrawal.USD" id="withdrawal.USD" placeholder="0" value="<?=$Withdrawal['withdrawal']['USD']?>" class="span2">
		<input type="text" name="withdrawal.EUR" id="withdrawal.EUR" placeholder="0" value="<?=$Withdrawal['withdrawal']['EUR']?>" class="span2">		
		<input type="submit" value="Save" class="btn btn-primary ">
</form>