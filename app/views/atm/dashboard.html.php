<div class="span10">
<h1>Balances</h1>
<table class="table table-condensed">
<?php foreach($details['balance'] as $key=>$val){?>
	<tr>
		<td><h2><?=$key?></h2></td>
		<td style="text-align:right "><h2><?=number_format($val,6)?>

		</h2></td>
		<td>&nbsp;</td>
		<td><a class="btn btn-success btn-large <?php if(!$verified){?>disabled<?php }?>" href="/ATM/deposit_<?=$key?>" >Deposit</a></td>
		<td><a class="btn btn-primary btn-large <?php if(!(float)$val>0){?>disabled<?php }?>" href="/ATM/withdraw_<?=$key?>">Withdraw</a></td>
	</tr>
<?php }?>
</table>
<a href="/ATM/index" class="btn btn-danger btn-large">Logout</a>
</div>