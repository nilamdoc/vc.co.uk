<h4>Transactions</h4>
<div>
	<table class="table table-condensed table-bordered table-hover" >
		<thead>
			<tr>
				<th>Date</th>
				<th>Transaction</th>
				<th>Amount BTC</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>
<?php foreach ($transactions as $tx){?>
		<tr>
			<td><?=gmdate('Y-M-d H:i:s',$tx['DateTime']->sec)?></td>
			<td><a href="/network/transactionhash/<?=$tx['TransactionHash']?>"><?=$tx['TransactionHash']?></a></td>
			<td style="text-align:right "><?=number_format($tx['Amount'],8)?></td>
			<td><?php if($tx['Added']==true){echo "Deposit";}else{echo "Withdraw";}?></td>
		</tr>
<?php 
	$Amount = $Amount + number_format($tx['Amount'],8);
} ?>
		<tr>
			<th colspan="2">Total</th>
			<td style="text-align:right "><?=number_format($Amount,8)?></td>
		</tr>
		</tbody>
	</table>
</div>
