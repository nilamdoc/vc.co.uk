<div class="well" style="background-image:url(/img/Stamp.png);background-position:bottom right;background-repeat:no-repeat;min-height:600px">
<h4>Bitcoin Transactions:</h4>
<?php 
if($StartDate==""){
$StartDate = gmdate('Y-m-d',mktime(0,0,0,gmdate('m',time()),gmdate('d',time()),gmdate('Y',time()))-60*60*24*30);
$EndDate = gmdate('Y-m-d',time()+1*60*60*24);
}else{
$StartDate=gmdate('Y-m-d',$StartDate->sec);
$EndDate=gmdate('Y-m-d',$EndDate->sec);
}
?>
<form action="/Admin/bitcointransaction" method="post">
<div class="input-append date" id="StartDate" data-date="<?=$StartDate?>" data-date-format="yyyy-mm-dd">
	<input class="span2" size="16" name="StartDate" type="text" value="<?=$StartDate?>" readonly>
	<span class="add-on"><i class="icon-calendar"></i></span>
</div>
<div class="input-append date" id="EndDate" data-date="<?=$EndDate?>" data-date-format="yyyy-mm-dd">
	<input class="span2" size="16"  name="EndDate" 	type="text" value="<?=$EndDate?>" readonly>
	<span class="add-on"><i class="icon-calendar"></i></span>
</div>
	<input type="submit" value="Get report" class="btn btn-primary">
<div class="alert alert-error" id="alert"><strong></strong></div>
</form>
<table class="table table-condensed table-bordered table-hover" style=" ">
	<tr>
		<th style="text-align:center;">Date</th>
		<th style="text-align:center ">Transaction</th>
		<th style="text-align:center ">Type</th>		
		<th style="text-align:center ">Username</th>		
		<th style="text-align:center ">Amount</th>				
		<th style="text-align:center ">Address</th>				
	</tr>
	<?php foreach($transactions as $tx){?>
	<tr>
		<td><?=gmdate('Y-M-d H:i:s',$tx['DateTime']->sec)?></td>
		<td><?=substr($tx['TransactionHash'],0,10)?>...</td>
		<td><?php if($tx['Added']==true){echo "Deposit";}else{echo "Withdrawal";}?></td>
		<td><a href="/Admin/detail/<?=$tx['username']?>" target="_blank"><?=$tx['username']?></a></td>
		<td><?=number_format($tx['Amount'],8)?></td>
		<td><a href="http://blockchain.info/address/<?=$tx['address']?>" target="_blank"><?=$tx['address']?></a></td>
	</tr>
	<?php }?>
</table>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
</div>
	<script src="/js/admin.js"></script>