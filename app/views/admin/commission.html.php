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
print_r($new);
foreach ($new	as $key=>$value){
?>
	<tr>
		<td><?=$key;?></td>
		<td><?=$value['Transactions']?></td>		
		<td><?=$value['BTC']?></td>
		<td><?=$value['GBP']?></td>
		<td><?=$value['EUR']?></td>
		<td><?=$value['USD']?></td>						
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
