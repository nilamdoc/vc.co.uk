<h4>Transactions</h4>
		<table class="table table-condensed table-bordered table-hover" >
		<thead>
			<tr>
				<th>Date</th>
				<th>Username</th>
				<th>Reference</th>				
				<th>Amount</th>
				<th>Type</th>
				<th>Approved</th>		
				<th>Action</th>								
			</tr>
		</thead>
		<tbody>
<?php 
foreach ($Details as $tx){?>
		<tr <?php ?> style="background-color:#669933 "></tr>
			<td><?=gmdate('Y-M-d H:i:s',$tx['TranDate']->sec)?></td>
			<td><?=$tx['username']?></td>
			<td><?=$tx['Reference']?></td>
			<td style="text-align:right "><strong class="label label-warning tooltip-x" rel="tooltip-x" data-placement="top" title="Withdraw"><?=number_format($tx['Amount'],2)?> <?=$tx['Currency']?></strong><br>
<strong class="label label-success  tooltip-x" rel="tooltip-x" data-placement="top" title="Balance">
			<?php if($tx['Currency']=='GBP'){echo number_format($tx['GBP'],2).' GBP';}?>
			<?php if($tx['Currency']=='USD'){echo number_format($tx['USD'],2).' USD';}?>
			<?php if($tx['Currency']=='EUR'){echo number_format($tx['EUR'],2).' EUR';}?></strong></td>
			<td><?php if($tx['Added']==true){echo "Deposit";}else{echo "Withdraw";}?></td>
			<td style="text-align:center"><?=$tx['Approved']?></td>			
			<td>
			<form action="/admin/approvewithdrawal" method="post" class="form form-horizontal">
				<input type="text" name="Amount" id="Amount" value="<?=$tx['Amount']?>"  max="<?=$tx['Amount']?>" min="1"  class="span1 tooltip-x" rel="tooltip-x" data-placement="top" title="Only numbers no comma ">
				<input type="hidden" name="id" id="id" value="<?=$tx['_id']?>">
				<input type="hidden" name="Currency" id="Currency" value="<?=$tx['Currency']?>">				
				<input type="submit" value="Approve" class="btn btn-primary tooltip-x" rel="tooltip-x" data-placement="top" title="Approve this transaction">
			</form>
			<a href="/admin/deletewithdrawal/<?=$tx['_id']?>" class="tooltip-x" rel="tooltip-x" data-placement="top" title="Cannot be recovered">Delete</a>
			<a href="/admin/rejectwithdrawal/<?=$tx['_id']?>/W1" id="RejectURL" class="tooltip-x" rel="tooltip-x" data-placement="top" title="User will be sent an email about rejection, cannot be recovered">Reject</a>			
			<select id="RejectReason" class="span2" onChange="RejectReason(this.value);">
			<?php foreach($reasons as $reason){	?>
				<option value="<?=$reason['code']?>"><?=$reason['reason']?></option>
			<?php }?>
			</select>
			</td>
		</tr>
<?php 
} ?>
		</tbody>
	</table>
