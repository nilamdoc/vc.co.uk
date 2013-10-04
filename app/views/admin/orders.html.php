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
<form action="/Admin/orders" method="post">
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
<table class="table table-condensed table-bordered table-hover" style="font-size:12px">
	<tr>
		<th style="text-align:center;">Date</th>
		<th style="text-align:center ">Action</th>
		<th style="text-align:center ">Amount</th>				
		<th style="text-align:center ">PerPrice</th>						
		<th style="text-align:center ">Total</th>				
		<th style="text-align:center ">Commission</th>						
		<th>Calculated</th>
		<th style="text-align:center ">Completed</th>		
		<th style="text-align:center ">Username</th>		
	</tr>
	<?php foreach($Orders as $od){?>
	<tr>
		<td><?=gmdate('Y-M-d H:i:s',$od['DateTime']->sec)?></td>
		<td><?=$od['Action']?> <?=$od['FirstCurrency']?>/<?=$od['SecondCurrency']?></td>
		<td><?=number_format($od['Amount'],8)?></td>
		<td><?=number_format($od['PerPrice'],4)?></td>				
		<td><?=number_format($od['PerPrice']*$od['Amount'],4)?></td>						
		<td><?=number_format($od['Commission']['Amount'],8)?> <?=$od['Commission']['Currency']?></td>						
		<td><?php
			if($od['Action']=="Buy"){
			echo number_format($od['Amount']*.8/100,8)." ".$od['Commission']['Currency'];
			}else{
			echo number_format($od['Amount']*$od['PerPrice']*.8/100,8)." ".$od['Commission']['Currency'];
			}
		?></td>
		<td><?=$od['Completed']?></td>				
		<td><a href="/Admin/detail/<?=$od['username']?>" target="_blank"><?=$od['username']?></a></td>
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