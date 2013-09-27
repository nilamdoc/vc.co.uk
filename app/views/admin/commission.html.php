<div class="well" style="background-image:url(/img/Stamp.png);background-position:bottom right;background-repeat:no-repeat;min-height:600px">
<h3>Users and Order status - last 30 days</h3>
<?php 
if($StartDate==""){
$StartDate = gmdate('Y-m-d',mktime(0,0,0,gmdate('m',time()),gmdate('d',time()),gmdate('Y',time()))-60*60*24*30);
$EndDate = gmdate('Y-m-d',time());
}else{
$StartDate=gmdate('Y-m-d',$StartDate->sec);
$EndDate=gmdate('Y-m-d',$EndDate->sec);
}
?>
<form action="/Admin/commission" method="post">
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
		<th rowspan="2" style="text-align:center;">Date</th>
		<th rowspan="2" style="text-align:center ">Transactions</th>
		<th colspan="4" style="text-align:center ;background-color:#D1F4CC">Commission</th>
	</tr>
	<tr>
		<th style="text-align:center ;background-color:#D1F4CC">BTC</th>
		<th style="text-align:center ;background-color:#B8EEB0">GBP</th>		
		<th style="text-align:center ;background-color:#B8EEB0">EUR</th>		
		<th style="text-align:center ;background-color:#B8EEB0">USD</th>
	</tr>	
<?php 
$BTC = 0; $USD = 0; $EUR = 0; $GBP = 0; $Transactions = 0;
foreach ($new	as $key=>$value){
?>
	<tr>
		<td><?=$key;?></td>
		<td><?=$value['Transactions']?></td>		
		<td><?=number_format($value['BTC'],8)?></td>
		<td><?=number_format($value['GBP'],2)?></td>
		<td><?=number_format($value['EUR'],2)?></td>
		<td><?=number_format($value['USD'],2)?></td>						
	</tr>
<?php 
$Transactions = $Transactions + $value['Transactions'];
$BTC = $BTC + $value['BTC'];
$GBP = $GBP + $value['GBP'];
$EUR = $EUR + $value['EUR'];
$USD = $USD + $value['USD'];
}?>
	<tr>
		<th><?=$t("Total");?></td>
		<th><?=$Transactions?></td>		
		<th><?=number_format($BTC,8)?></td>
		<th><?=number_format($GBP,2)?></td>
		<th><?=number_format($EUR,2)?></td>
		<th><?=number_format($USD,2)?></td>						
	</tr>
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