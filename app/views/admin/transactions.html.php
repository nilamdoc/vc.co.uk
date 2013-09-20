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
			<a href="/admin/sendemailtransaction/<?=$tx['_id']?>" class="tooltip-x label label-success" rel="tooltip-x" data-placement="top" title="Send customer an email to deposit funds in our bank">Send Approval Email</a>
			<a href="/admin/deletetransaction/<?=$tx['_id']?>" class="tooltip-x label label-warning" rel="tooltip-x" data-placement="top" title="Cannot be recovered">Delete</a>
			<a href="/admin/rejecttransaction/<?=$tx['_id']?>/D1"  class="tooltip-x label label-important" rel="tooltip-x" data-placement="top" title="User will be sent an email about rejection, cannot be recovered">Reject ></a>			
			<select id="RejectReason" class="span2 label label-important" onChange="RejectReason(this.value);">
			<?php foreach($reasons as $reason){	?>
				<option value="<?=$reason['code']?>"><?=$reason['reason']?></option>
			<?php }?>
			</select>
			<form action="/admin/approvetransaction" method="post" class="form form-horizontal">
				<input type="text" name="Amount" id="Amount" value="<?=$tx['Amount']?>" max="<?=$tx['Amount']?>" min="1" class="span1 tooltip-x" rel="tooltip-x" data-placement="top" title="Only numbers no comma ">
				<input type="hidden" name="id" id="id" value="<?=$tx['_id']?>">
				<input type="hidden" name="Currency" id="Currency" value="<?=$tx['Currency']?>">				
				<input type="submit" value="Deposit to ibwt" class="btn btn-primary tooltip-x" rel="tooltip-x" data-placement="top" title="Approve this transaction">
			</form>

			</td>
		</tr>
<?php 
} ?>
		</tbody>
	</table>
