<?php use lithium\util\String;?>
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
	<tr>
		<th style="text-align:center ">Account name</th>
		<th style="text-align:center ">Sort code</th>
		<th style="text-align:center ">Account number</th>
		<th style="text-align:center ">Bank name</th>
		<th style="text-align:center ">Bank address</th>
	</tr>
<?php foreach($details as $dt){?>
	<tr>
		<td style="text-align:center "><?=$dt['bank.accountname']?></td>
		<td style="text-align:center "><?=$dt['bank.sortcode']?></td>
		<td style="text-align:center "><?=$dt['bank.accountnumber']?></td>
		<td style="text-align:center "><?=$dt['bank.bankname']?><br>
			<?=$dt['bank.branchaddress']?></td>
		<td style="text-align:center ">
		<?php if($dt['bank.verified']!="Yes"){?>
		<a class="btn btn-primary" href="/Admin/bankapprove/<?=$dt['username']?>">Verify</a>		
		<?php }else{?>
		<span class="label label-success">Verified</span>
		<?php }?>
		</td>				
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
<div class="span5">
		<div class="navbar">
			<div class="navbar-inner">
			<a class="brand" href="#"><?=$t('Pending Orders')?> </a>
			</div>
		<table class="table table-condensed table-bordered table-hover" >
		<thead>
			<tr>
				<th style="text-align:center "><?=$t('Exchange')?></th>
				<th style="text-align:center "><?=$t('Price')?></th>
				<th style="text-align:center "><?=$t('Amount')?></th>
			</tr>
		</thead>
		<tbody>
				<?php foreach($UserOrders as $YO){ ?>
					<tr>
						<td style="text-align:left ">
						<a href="/ex/RemoveOrder/<?=String::hash($YO['_id'])?>/<?=$YO['_id']?>/<?=$sel_curr?>" title="Remove this order">
							<i class="icon-remove"></i></a> &nbsp; 
						<?=$YO['Action']?> <?=$YO['FirstCurrency']?>/<?=$YO['SecondCurrency']?></td>
						<td style="text-align:right "><?=number_format($YO['PerPrice'],3)?>...</td>
						<td style="text-align:right "><?=number_format($YO['Amount'],3)?>...</td>

					</tr>
				<?php }?>					
		</tbody>
	</table>
		</div>
	</div>	
			<div class="span5"  style="height:334px;">
			<div class="navbar">
				<div class="navbar-inner">
				<a class="brand" href="#"><?=$t('Completed orders')?></a>
				</div>
				<div id="YourCompleteOrders" style="height:300px;overflow:auto;">			
			<table class="table table-condensed table-bordered table-hover" style="font-size:11px">
				<thead>
					<tr>
						<th style="text-align:center "><?=$t('Exchange')?></th>
						<th style="text-align:center "><?=$t('Price')?></th>
						<th style="text-align:center "><?=$t('Amount')?></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach($UserCompleteOrders as $YO){ ?>
					<tr style="cursor:pointer"
					class=" tooltip-x" rel="tooltip-x" data-placement="top" title="<?=$YO['Action']?> <?=number_format($YO['Amount'],3)?> at 
					<?=number_format($YO['PerPrice'],8)?> on <?=gmdate('Y-m-d H:i:s',$YO['DateTime']->sec)?> from <?=$YO['Transact.username']?>">
						<td style="text-align:left ">
						<?=$YO['Action']?> <?=$YO['FirstCurrency']?>/<?=$YO['SecondCurrency']?></td>
						<td style="text-align:right "><?=number_format($YO['PerPrice'],3)?>...</td>
						<td style="text-align:right "><?=number_format($YO['Amount'],3)?>...</td>
					</tr>
				<?php }?>					
				</tbody>
			</table>
				</div>
			</div>

</div>