<table class="table">
<thead>
	<th>Collection</th>
	<th>Fields</th>
	<th>Conditions</th>
	<th>Order</th>
	<th>Records</th>
	<th>Limit</th>	
	<th>Skip</th>		
	<th>Batchsize</th>		
	<th>Flags</th>				
	<th>T-millis</th>					
</thead>
<?php
$SQL = $GLOBALS['Show_SQL'];
foreach ($SQL as $s){
//echo "<pre>";
//print_r($s);
//echo "</pre>";
?>
<tr>
	<td><?=$s['query']['ns']?></td>
	<td><?php 
	foreach ($s['query']['fields'] as $key=>$val){
		print_r($key);
		echo ": ";
		print_r($val);
		echo ", ";		
	}
	?></td>
	<td>
	<?php
	foreach ($s['query']['query']['$query'] as $key=>$val){
		print_r($key);
		echo ": ";
		print_r($val);
		echo ", ";		
	}?>
	</td>
	<td><?php
	foreach ($s['query']['query']['$orderby'] as $key=>$val){
		print_r($key);
		echo ": ";
		print_r($val);
		echo ", ";		
	}?></td>
	<td style="text-align:center"><?=$s['explain']['n']?></td>
	<td style="text-align:center"><?=$s['query']['limit']?></td>	
	<td style="text-align:center"><?=$s['query']['skip']?></td>		
	<td style="text-align:center"><?=$s['query']['batchSize']?></td>		
	<td style="text-align:center"><?=$s['query']['flags']?></td>				
	<td style="text-align:center"><?=$s['explain']['millis']?></td>					
</tr>
<?php
}
?>
</table>