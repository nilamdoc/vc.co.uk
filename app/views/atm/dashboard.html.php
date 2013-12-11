<div class="span10">
<h1>Balances</h1>
<table class="table table-condensed">
<?php foreach($details['balance'] as $key=>$val){?>
	<tr>
		<td><h2><?=$key?></h2></td>
		<td style="text-align:right "><h2><?=number_format($val,6)?></h2></td>
		<td>&nbsp;</td>
		<td><a class="btn btn-success btn-large" href="/ATM/deposit/<?=$key?>">Deposit</a></td>
		<td><a class="btn btn-primary btn-large" href="/ATM/withdraw/<?=$key?>">Withdraw</a></td>
	</tr>
<?php }?>
</table>
</div>