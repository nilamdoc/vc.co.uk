<div class="well" style="background-image:url(/img/Stamp.png);background-position:bottom right;background-repeat:no-repeat;min-height:600px">
<h3>Users and Order status - last 30 days</h3>
<table class="table table-condensed table-bordered table-hover" style=" ">
	<tr>
		<th rowspan="2" style="text-align:center;">Date</th>
		<th rowspan="2" style="text-align:center ">Transactions</th>
		<th colspan="4" style="text-align:center ;background-color:#D1F4CC">Commission</th>
	</tr>
	<tr>
		<th style="text-align:center ;background-color:#D1F4CC">BTC</th>
		<th style="text-align:center ;background-color:#B8EEB0">GBP</th>		
		<th style="text-align:center ;background-color:#B8EEB0">EUR</th>		
		<th style="text-align:center ;background-color:#B8EEB0">USD</th>
	</tr>	
<?php 
print_r($Commissions);
foreach ($Commissions['result'] as $co){
				$COdate = date_create($co['_id']['year']."-".$co['_id']['month']."-".$co['_id']['day']);			
				$CODate = date_format($COdate,"Y-m-d");
?>
	<tr>
		<td><?=$CODate?></td>
		<td><?php if($co['CommissionCurrency']=='BTC'){echo number_format($co['CommissionAmount'],8);}?></td>
		<td><?php if($co['CommissionCurrency']=='GBP'){echo number_format($co['CommissionAmount'],2);}?></td>		
		<td><?php if($co['CommissionCurrency']=='EUR'){echo number_format($co['CommissionAmount'],2);}?></td>		
		<td><?php if($co['CommissionCurrency']=='USD'){echo number_format($co['CommissionAmount'],2);}?></td>		
	</tr>
<?php }?>
</table>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
</div>
