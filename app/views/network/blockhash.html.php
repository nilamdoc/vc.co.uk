<table class="table table-condensed table-striped table-bordered" style="background-color:white ">
	<tr>
		<td>Next Block </td>
		<td><code><a href="/network/blockhash/<?php if(isset($nextblockhash)){echo $nextblockhash;}?>">
		<?php if(isset($nextblockhash)){echo $nextblockhash;}?></a></code></td>
		<td><?php if(isset($nextblock)){echo $nextblock;}?></td>
	</tr>	
	<tr>
		<td>Hash</td>
		<td><code><strong><?=$getblock['hash']?></strong></code></td>
		<td><strong><?=$getblock['height']?></strong></td>
	</tr>
	<tr>
		<td>Prev Block </td>
		<td><code><a href="/network/blockhash/<?=$prevblockhash?>"><?=$prevblockhash?></a></code></td>
		<td><?=$prevblock?></td>
	</tr>		
</table>
<h3>Details:</h3>
<table class="table table-condensed table-striped table-bordered" style="background-color:white ">
	<tr>
		<td>Hash</td>
		<td><code><strong><?=$getblock['hash']?></strong></code></td>
	</tr>
	<tr>
		<td>Block</td>
		<td><strong><?=$getblock['height']?></strong></td>
	</tr>
	<tr>
		<td>Confirmations</td>
		<td><?=$getblock['confirmations']?></td>
	</tr>
	<tr>
		<td>Size</td>
		<td><?=$getblock['size']?></td>
	</tr>
	<tr>
		<td>Version</td>
		<td><?=$getblock['version']?></td>
	</tr>
	<tr>
		<td>Merkle root</td>
		<td><code><?=$getblock['merkleroot']?></code></td>
	</tr>	
	<tr>
		<td>Time</td>
		<td><?=$getblock['time']?></td>
	</tr>		
	<tr>
		<td>Nonce</td>
		<td><?=$getblock['nonce']?></td>
	</tr>		
	<tr>
		<td>Bits</td>
		<td><?=$getblock['bits']?></td>
	</tr>		
	<tr>
		<td>Difficulty</td>
		<td><?=$getblock['difficulty']?></td>
	</tr>		
</table>
<h3>Transaction in this block:</h3>
<table class="table table-condensed table-striped table-bordered" style="background-color:white ">
	<thead>
		<tr>
			<th>ID</th>
			<th>Transaction hash</th>
		</tr>
	</thead>
<?php $tx = count($getblock['tx']);
	for($i=0;$i<$tx;$i++){
?>
	<tr>
		<td><?=$i?></td>
		<td><code><a href="/network/transactionhash/<?php print_r($getblock['tx'][$i])?>"><?php print_r($getblock['tx'][$i])?></a></code></td>
	</tr>		
<?php }?>
</table>