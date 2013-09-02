<h4>Transactions done by <?=$address?></h4><h5>First seen on <?=$addressfirstseen?></h5>

<p>The data below is fetched from <a href="http://blockexplorer.com/q/mytransactions/<?=$address?>" target="_blank">http://blockexplorer.com/q/mytransactions/<?=$address?></a>.<br>
Please visit <a href="http://blockexplorer.com/" target="_blank">blockexplorer.com</a> for details.</p>
<table class="table table-condensed table-striped table-bordered" style="background-color:white ">
	<thead>
		<tr>
			<th>ID</th>
			<th>Transaction hash</th>
			<th>Time</th>
			<th>Block</th>			
			<th>Amount</th>						
		</tr>
	</thead>
	<?php 
		$j = 1;
		$value = 0;
		foreach($transactions as $t){?>
		<tr>
			<td><?=$j?></td>
			<td><code><a href="/network/transactionhash/<?php echo $t->hash;?>"><?php echo $t->hash;?></a></code></td>			
			<td><?php echo $t->time;?></td>						
			<td><a href="/network/blockhash/<?php echo $t->block;?>"><?php echo $t->blocknumber;?></a></td>									
			<td><?php 
				for($i=0;$i<count($t->out);$i++){
					if($t->out[$i]->address==$address){
						$value = $value + $t->out[$i]->value;
						echo $t->out[$i]->value;
					}
				}
			?>
			</td>
		</tr>
	<?php 
	$j++;
	}	?>
	<tr>
		<td colspan="4"><strong>Total</strong></td>
		<td><strong><?=$value?></strong></td>
	</tr>
	<tr>
		<td colspan="4"><strong>Spent</strong></td>
		<td><strong><?=$addressbalance-$value?></strong></td>
	</tr>
	<tr>
		<td colspan="4"><strong>Address Balance</strong></td>
		<td><strong><?=$addressbalance?></strong></td>
	</tr>	
</table>
