<div class="well" style="background-image:url(/img/Stamp.png);background-position:bottom right;background-repeat:no-repeat;min-height:600px">
<h3>Registered Users - last 30 days</h3>
<table class="table table-condensed table-bordered table-hover" style=" ">
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
foreach($new as $key=>$value){
	?>
	<tr>
		<td><?=$key;?></td>
		<td><?=$value['Register']?>&nbsp;</td>
		<td><?php if(count($value['Buy']['USD']['N'])>0){echo $value['Buy']['USD']['N']['Amount']."/".$value['Buy']['USD']['N']['TotalAmount'];}?>&nbsp;</td>				
		<td><?php if(count($value['Buy']['GBP']['N'])>0){echo $value['Buy']['GBP']['N']['Amount']."/".$value['Buy']['GBP']['N']['TotalAmount'];}?>&nbsp;</td>				
		<td><?php if(count($value['Buy']['EUR']['N'])>0){echo $value['Buy']['EUR']['N']['Amount']."/".$value['Buy']['EUR']['N']['TotalAmount'];}?>&nbsp;</td>				
		<td><?php if(count($value['Buy']['USD']['Y'])>0){echo $value['Buy']['USD']['Y']['Amount']."/".$value['Buy']['USD']['Y']['TotalAmount'];}?>&nbsp;</td>				
		<td><?php if(count($value['Buy']['GBP']['Y'])>0){echo $value['Buy']['GBP']['Y']['Amount']."/".$value['Buy']['GBP']['Y']['TotalAmount'];}?>&nbsp;</td>				
		<td><?php if(count($value['Buy']['EUR']['Y'])>0){echo $value['Buy']['EUR']['Y']['Amount']."/".$value['Buy']['EUR']['Y']['TotalAmount'];}?>&nbsp;</td>						
		<td><?php if(count($value['Sell']['USD']['N'])>0){echo $value['Sell']['USD']['N']['Amount']."/".$value['Sell']['USD']['N']['TotalAmount'];}?>&nbsp;</td>				
		<td><?php if(count($value['Sell']['GBP']['N'])>0){echo $value['Sell']['GBP']['N']['Amount']."/".$value['Sell']['GBP']['N']['TotalAmount'];}?>&nbsp;</td>				
		<td><?php if(count($value['Sell']['EUR']['N'])>0){echo $value['Sell']['EUR']['N']['Amount']."/".$value['Sell']['EUR']['N']['TotalAmount'];}?>&nbsp;</td>				
		<td><?php if(count($value['Sell']['USD']['Y'])>0){echo $value['Sell']['USD']['Y']['Amount']."/".$value['Sell']['USD']['Y']['TotalAmount'];}?>&nbsp;</td>				
		<td><?php if(count($value['Sell']['GBP']['Y'])>0){echo $value['Sell']['GBP']['Y']['Amount']."/".$value['Sell']['GBP']['Y']['TotalAmount'];}?>&nbsp;</td>				
		<td><?php if(count($value['Sell']['EUR']['Y'])>0){echo $value['Sell']['EUR']['Y']['Amount']."/".$value['Sell']['EUR']['Y']['TotalAmount'];}?>&nbsp;</td>				
						
	</tr>
<?php  }?>
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
