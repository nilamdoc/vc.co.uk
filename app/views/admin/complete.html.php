<div class="well" style="background-image:url(/img/Stamp.png);background-position:bottom right;background-repeat:no-repeat;min-height:600px">
<h3>Completed Orders - last 30 days</h3>
<?php 
if($StartDate==""){
$StartDate = gmdate('Y-m-d',mktime(0,0,0,gmdate('m',time()),gmdate('d',time()),gmdate('Y',time()))-60*60*24*30);
$EndDate = gmdate('Y-m-d',time()+1*60*60*24);
}else{
$StartDate=gmdate('Y-m-d',$StartDate->sec);
$EndDate=gmdate('Y-m-d',$EndDate->sec);
}
?>
<form action="/Admin/complete" method="post">
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
	<thead>
		<tr>
			<th>Date</th>
			<th colspan="5" style="text-align:center ">Buy</th>			
			<th colspan="5" style="text-align:center ">Sell</th>						
		</tr>
		<tr>
			<td></td>
			<td>Username</td>
			<td>Pair</td>
			<td>Amount</td>
			<td>Price</td>
			<td>Commission</td>
			<td>Username</td>
			<td>Pair</td>
			<td>Amount</td>
			<td>Price</td>
			<td>Commission</td>			
		</tr>
	</thead>
	<?php foreach($FinalOrders as $FO){
	$diff = false;
	if(number_format($FO['Buy']['Amount'],6)!=number_format($FO['Sell']['Amount'],6)){
		$diff = true;
	}
	if(number_format($FO['Buy']['PerPrice'],4)!=number_format($FO['Sell']['PerPrice'],4)){
		$diff = true;
	}
	?>
	<tr <?php if($diff){echo ' style="background-color:#FFCC66 "';}?>>
		<td><?=gmdate('Y-m-d H:i:s',$FO['DateTime']->sec)?></td>
		<td><?=$FO['Buy']['username']?><br>
		<small><?=$FO['Buy']['_id']?></small>
		</td>
		<td><?=$FO['Buy']['pair']?></td>		
		<td><?=number_format($FO['Buy']['Amount'],6)?></td>		
		<td><?=number_format($FO['Buy']['PerPrice'],4)?></td>		
		<td><?=$FO['Buy']['Commission']?></td>
		<td><?=$FO['Sell']['username']?><br>
		<small><?=$FO['Sell']['_id']?></small>
		</td>
		<td><?=$FO['Sell']['pair']?></td>		
		<td><?=number_format($FO['Sell']['Amount'],6)?></td>		
		<td><?=number_format($FO['Sell']['PerPrice'],4)?></td>		
		<td><?=$FO['Sell']['Commission']?></td>
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
<br>
</div>
	<script src="/js/admin.js"></script>