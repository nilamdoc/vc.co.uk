<h4>Transactions</h4>
		<table class="table table-condensed table-bordered table-hover" >
		<thead>
			<tr>
				<th>Date</th>
				<th>Username</th>
				<th>Reference</th>				
				<th>Amount</th>
				<th>Currency</th>				
				<th>Type</th>
				<th>Approved</th>		
				<th>Action</th>								
			</tr>
		</thead>
		<tbody>
<?php 
foreach ($Fiattransactions as $tx){?>
		<tr <?php ?> style="background-color:#669933 "></tr>
			<td><?=gmdate('Y-M-d H:i:s',$tx['DateTime']->sec)?></td>
			<td><?=$tx['username']?></td>
			<td><?=$tx['Reference']?></td>
			<td style="text-align:right "><?=number_format($tx['Amount'],2)?></td>
			<td style="text-align:right "><?=$tx['Currency']?></td>			
			<td><?php if($tx['Added']==true){echo "Deposit";}else{echo "Withdraw";}?></td>
			<td style="text-align:center"><?=$tx['Approved']?></td>			
			<td>
			<form action="/admin/approvetransaction" method="post" class="form form-horizontal">
				<input type="text" class="span1" name="Amount" id="Amount" value="<?=number_format($tx['Amount'],2)?>">
				<input type="hidden" name="id" id="id" value="<?=$tx['_id']?>">
				<input type="hidden" name="Currency" id="Currency" value="<?=$tx['Currency']?>">				
				<input type="submit" value="Approve" class="btn btn-primary tooltip-x" rel="tooltip-x" data-placement="top" title="Approve this transaction">
			</form>
			<a href="/admin/deletetransaction/<?=$tx['_id']?>" class="tooltip-x" rel="tooltip-x" data-placement="top" title="Cannot be recovered">Delete</a>
			<a href="/admin/rejecttransaction/<?=$tx['_id']?>"  class="tooltip-x" rel="tooltip-x" data-placement="top" title="User will be sent an email about rejection, cannot be recovered">Reject</a>			
			</td>
		</tr>
<?php 
} ?>
		</tbody>
	</table>
