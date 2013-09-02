<div class="well" style="background-image:url(/img/Stamp.png);background-position:bottom right;background-repeat:no-repeat;height:600px">
<h3>Registered Users - last 30 days</h3>
<table class="table table-condensed table-bordered table-hover">
	<tr>
		<th rowspan="3">Date</th>
		<th rowspan="3">Users</th>
		<th colspan="6">Buy</th>
		<th colspan="6">Sell</th>		
	</tr>
	<tr>
		<th colspan="3">Pending</th>
		<th colspan="3">Complete</th>		
		<th colspan="3">Pending</th>
		<th colspan="3">Complete</th>		
	</tr>
	<tr>
		<th>BTC/USD</th>
		<th>BTC/GBP</th>		
		<th>BTC/EUR</th>		
		<th>BTC/USD</th>
		<th>BTC/GBP</th>		
		<th>BTC/EUR</th>		
		<th>BTC/USD</th>
		<th>BTC/GBP</th>		
		<th>BTC/EUR</th>		
		<th>BTC/USD</th>
		<th>BTC/GBP</th>		
		<th>BTC/EUR</th>		
	</tr>	
	<?php 
	print_r($TotalOrders);	
foreach($UserRegistrations['result'] as $UR){
$date = date_create($UR['_id']['year']."-".$UR['_id']['month']."-".$UR['_id']['day']);
	?>
	<tr>
		<td><?=date_format($date, 'Y-M-d');?></td>
		<td><?=$UR['count']?></td>
	</tr>
<?php }?>
</table>
</div>
