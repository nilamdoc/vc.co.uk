<h2>Transaction details</h2>
<table class="table table-condensed table-striped table-bordered" style="background-color:white ">
	<tr>
		<td>Tx ID</td>
		<td><code><?=$decoderawtransaction['txid']?></code></td>
	</tr>
	<tr>
		<td>Version</td>
		<td><?=$decoderawtransaction['version']?></td>
	</tr>
	<tr>
		<td>Lock time</td>
		<td><?=$decoderawtransaction['locktime']?></td>
	</tr>
	<tr>
		<td>Last since Block</td>
		<td><code><a href="/network/blockhash/<?php print_r($listsinceblock['lastblock'])?>"><?php print_r($listsinceblock['lastblock'])?></a></code></td>
	</tr>

</table>
<h3>Transaction In</h3>
<table class="table table-condensed table-striped table-bordered" style="background-color:white ">
<?php
	foreach($decoderawtransaction['vin'] as $in){
?>
	<tr>
		<td>Tx ID</td>
		<td><strong><code><a href="/network/transactionhash/<?php if(isset($in['txid'])){echo $in['txid'];}?>">
		<?php if(isset($in['txid'])){echo $in['txid'];}?></a></code></strong></td>
	</tr>
	<tr>
		<td>Vout</td>
		<td><?php if(isset($in['vout'])){echo $in['vout'];}?></td>
	</tr>
	<tr>
		<td>scriptSig: asm</td>
		<td><code><?php if(isset($in['scriptSig']['asm'])){echo substr($in['scriptSig']['asm'],0,50);}?>...</code></td>
	</tr>
	<tr>
		<td>scriptSig: hex</td>
		<td><?php if(isset($in['scriptSig']['hex'])){echo substr($in['scriptSig']['hex'],0,50);}?>...</td>
	</tr>
	<tr>
		<td>sequence</td>
		<td><?=$in['sequence']?></td>
	</tr>
<?php }?>
</table>
<h3>Transaction Out</h3>
<table class="table table-condensed table-striped table-bordered" style="background-color:white ">
<?php
	foreach($decoderawtransaction['vout'] as $out){
?>
	<tr>
		<td><strong>Amount</strong></td>
		<td><strong><?=$out['value']?></strong></td>
	</tr>
	<tr>
		<td>N</td>
		<td><?=$out['n']?></td>
	</tr>
	<tr>
	<td colspan="2">
	<table class="table table-condensed table-striped table-bordered" style="background-color:white ">
		<thead>
			<tr>
				<th>Addresses</th>								
				<th>Script pub key: asm</th>
				<th>Script pub key: hex</th>
				<th>Require sign</th>
				<th>Type</th>				

			</tr>
			<tr>
				<td><?php
				foreach($out['scriptPubKey']['addresses'] as $address){
				?>
				<a href="/network/address/<?=$address?>"><?=$address?></a>
				<?php
				}
				?></td>
				<td><?=substr($out['scriptPubKey']['asm'],0,20)?>...</td>
				<td><?=substr($out['scriptPubKey']['hex'],0,20)?>...</td>				
				<td><?=$out['scriptPubKey']['reqSigs']?></td>				
				<td><?=$out['scriptPubKey']['type']?></td>				
			</tr>
			
		</thead>
	</table>
	</td>
	</tr>
<?php }?>
</table>
