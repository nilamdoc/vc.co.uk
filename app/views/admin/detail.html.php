
<table class="table table-condensed table-bordered table-hover" >
	<thead>
	<tr>
			<th>Username</th>
			<th>Full Name</th>			
			<th>Email</th>						
			<th>Sign in</th>
			<th>IP</th>
	</tr>			
	</thead>
	<tbody>
<?php foreach($user as $ur){?>	
	<tr>
		<td><?=$ur['username']?></a></td>
		<td><?=$ur['firstname']?> <?=$ur['lastname']?></td>		
		<td><?=$ur['email']?></td>				
		<td><?=gmdate('Y-M-d H:i:s',$ur['created']->sec)?></td>
		<td><?=$ur['ip']?></td>
	</tr>
<?php  }?>
	<tr>
		<th style="text-align:center ">BTC</th>
		<th style="text-align:center ">USD</th>
		<th style="text-align:center ">GBP</th>
		<th style="text-align:center ">EUR</th>
		<th style="text-align:center ">Email</th>
	</tr>
<?php foreach($details as $dt){?>
	<tr>
		<td style="text-align:center "><?=number_format($dt['balance.BTC'],8)?></td>
		<td style="text-align:center "><?=number_format($dt['balance.USD'],2)?></td>
		<td style="text-align:center "><?=number_format($dt['balance.GBP'],2)?></td>
		<td style="text-align:center "><?=number_format($dt['balance.EUR'],2)?></td>
		<td style="text-align:center "><?=$dt['email.verified']?></td>
	</tr>
<?php  }?>
	</tbody>
	</table>
<div class="row">
	<div class="span5">
		<div class="navbar">
			<div class="navbar-inner">
			<a class="brand" href="#"><?=$t('Transactions in BTC')?> </a>
			</div>
		<table class="table table-condensed table-bordered table-hover" >
		<thead>
			<tr>
				<th>Date</th>
				<th>Amount BTC</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>
<?php foreach ($transactions as $tx){?>
		<tr <?php ?> style="background-color:#669933 "></tr>
			<td><?=gmdate('Y-M-d H:i:s',$tx['DateTime']->sec)?></td>
			<td style="text-align:right "><?=number_format($tx['Amount'],8)?></td>
			<td><?php if($tx['Added']==true){echo "Deposit";}else{echo "Withdraw";}?></td>
		</tr>
<?php 
	$Amount = $Amount + number_format($tx['Amount'],8);
} ?>
		<tr>
			<th >Total</th>
			<td style="text-align:right "><?=number_format($Amount,8)?></td>
			<td></td>
		</tr>
		</tbody>
	</table>
		</div>
	</div>
	<div class="span5">
		<div class="navbar">
			<div class="navbar-inner">
			<a class="brand" href="#"><?=$t('Transaction in other currencies')?> </a>
			</div>
		<table class="table table-condensed table-bordered table-hover" >
		<thead>
			<tr>
				<th>Date</th>
				<th>Amount</th>
				<th>Currency</th>				
				<th>Type</th>
				<th>Approved</th>				
			</tr>
		</thead>
		<tbody>
<?php 
foreach ($Fiattransactions as $tx){?>
		<tr <?php ?> style="background-color:#669933 "></tr>
			<td><?=gmdate('Y-M-d H:i:s',$tx['DateTime']->sec)?></td>
			<td style="text-align:right "><?=number_format($tx['Amount'],2)?></td>
			<td style="text-align:right "><?=$tx['Currency']?></td>			
			<td><?php if($tx['Added']==true){echo "Deposit";}else{echo "Withdraw";}?></td>
			<td style="text-align:center"><?=$tx['Approved']?></td>			

		</tr>
<?php 
} ?>
		</tbody>
	</table>
			
	</div>
</div>