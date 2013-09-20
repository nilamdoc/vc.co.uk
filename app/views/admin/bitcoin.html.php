<h4>Bitcoin</h4>
<form action="/Admin/bitcoin" method="post">
	<input type="text" name="transactionhash" id="transactionhash" value="" class="span5">
	<input type="submit" value="Check this transaction" class="btn btn-primary">
</form>
<?php 
if(count($transactions)>0){
?>
<table class="table table-condensed table-bordered table-hover" >
	<thead>
		<tr>
			<th>Transaction</th>
			<th>Username</th>			
			<th>Address</th>
			<th>Amount</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
<?php  foreach($transactions as $tx){?>
	<tr>
		<td><?=$tx['TransactionHash']?></td>
		<td><?=$tx['username']?></td>
		<td><?=$tx['address']?></td>
		<td><?=$tx['Amount']?></td>
		<td><a href="/Admin/reverse/<?=$tx['TransactionHash']?>/<?=$tx['username']?>/<?=$tx['Amount']?>">Reverse</a></td>
	</tr>
<?php } ?>
</tbody>
</table>
<?php }?>