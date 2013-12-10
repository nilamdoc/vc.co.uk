<div class="well" style="background-image:url(/img/Stamp.png);background-position:bottom right;background-repeat:no-repeat;min-height:600px">
<h3>Users and Order status - last 30 days</h3>
<?php 
if($StartDate==""){
$StartDate = gmdate('Y-m-d',mktime(0,0,0,gmdate('m',time()),gmdate('d',time()),gmdate('Y',time()))-60*60*24*30);
$EndDate = gmdate('Y-m-d',time()+1*60*60*24);
}else{
$StartDate=gmdate('Y-m-d',$StartDate->sec);
$EndDate=gmdate('Y-m-d',$EndDate->sec);
}
?>
<form action="/Admin/index" method="post">
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
		<th rowspan="3" style="text-align:center;">Date</th>
		<th rowspan="3" style="text-align:center ">Users</th>
		<th colspan="<?=count($trades)*2?>" style="text-align:center ;background-color:#D1F4CC">Buy / Sell</th>
	</tr>
	<tr>
		<th colspan="<?=count($trades)?>" style="text-align:center ;background-color:#B8EEB0">Pending</th>
		<th colspan="<?=count($trades)?>" style="text-align:center ;background-color:#D1F4CC">Complete</th>		
	</tr>
	<tr>
	<?php foreach ($trades as $trade){?>
		<th style="text-align:center ;background-color:#B8EEB0"><?=$trade['trade']?></th>
	<?php }?>
	<?php foreach ($trades as $trade){?>
		<th style="text-align:center ;background-color:#B8EEB0"><?=$trade['trade']?></th>
	<?php }?>
	</tr>	
	<?php 
foreach($new as $key=>$value){
	?>
	<tr>
		<td rowspan="2"><?=$key;?></td>
		<td style="text-align:center " rowspan="2"><?=$value['Register']?>&nbsp;</td>
<!--Buy-Pending--->
	<?php foreach ($trades as $trade){
		$FC = strtoupper(substr($trade['trade'],0,3));
		$SC = strtoupper(substr($trade['trade'],4,3));
	?>
			<td style=" background-color:#B8EEB0 "><?php if(count($value['Buy'][$SC]['N'])>0){?><?php echo $value['Buy'][$SC]['N']['Amount']."/".$value['Buy'][$SC]['N']['TotalAmount'];?><br><small>
			<?php echo number_format($value['Buy'][$SC]['N']['TotalAmount']/$value['Buy'][$SC]['N']['Amount'],4);?>
			</small>
	&nbsp;<?php }?></td>				
	<?php }?>
<!--Buy-Pending-->
<!--Buy-Complete-->
	<?php foreach ($trades as $trade){
		$FC = strtoupper(substr($trade['trade'],0,3));
		$SC = strtoupper(substr($trade['trade'],4,3));
	?>
		<td style=";background-color:#D1F4CC "><?php if(count($value['Buy'][$SC]['Y'])>0){?><?php echo $value['Buy'][$SC]['Y']['Amount']."/".$value['Buy'][$SC]['Y']['TotalAmount'];?><br><small>
		<?php echo number_format($value['Buy'][$SC]['Y']['TotalAmount']/$value['Buy'][$SC]['Y']['Amount'],4);?>
		</small>
&nbsp;<?php }?></td>				
	<?php }?>
<!--Buy-Complete-->
	</tr><tr>
<!--Sell-Pending--->
	<?php foreach ($trades as $trade){
		$FC = strtoupper(substr($trade['trade'],0,3));
		$SC = strtoupper(substr($trade['trade'],4,3));
	?>
		<td style="background-color:#FEE1AF "><?php if(count($value['Sell'][$SC]['N'])>0){?><?php echo $value['Sell'][$SC]['N']['Amount']."/".$value['Sell'][$SC]['N']['TotalAmount'];?><br><small>
		<?php echo number_format($value['Sell'][$SC]['N']['TotalAmount']/$value['Sell'][$SC]['N']['Amount'],4);?>
		</small>
&nbsp;<?php }?></td>				
	<?php }?>
<!--Sell-Pending-->
<!--Sell-Complete-->
	<?php foreach ($trades as $trade){
		$FC = strtoupper(substr($trade['trade'],0,3));
		$SC = strtoupper(substr($trade['trade'],4,3));
	?>
		<td style="background-color:#FEEABA "><?php if(count($value['Sell'][$SC]['Y'])>0){?><?php echo $value['Sell'][$SC]['Y']['Amount']."/".$value['Sell'][$SC]['Y']['TotalAmount'];?><br><small>
		<?php echo number_format($value[$SC]['USD']['Y']['TotalAmount']/$value[$SC]['USD']['Y']['Amount'],4);?>
		</small>
&nbsp;<?php }?></td>				
	<?php }?>
<!--Sell-Complete-->
	</tr>
<?php  
$users = $users + $value['Register'];
?>
<?php foreach ($trades as $trade){
	$FC = strtoupper(substr($trade['trade'],0,3));
	$SC = strtoupper(substr($trade['trade'],4,3));

	$BuyNAmount = 'Buy'.$SC.'NAmount';
	$BuyNTotalAmount = 'Buy'.$SC.'NTotalAmount';
	$BuyYAmount = 'Buy'.$SC.'YAmount';
	$BuyYTotalAmount = 'Buy'.$SC.'YTotalAmount';

$$BuyNAmount = $$BuyNAmount + $value['Buy'][$SC]['N']['Amount'];
$$BuyNTotalAmount = $$BuyNTotalAmount + $value['Buy'][$SC]['N']['TotalAmount'];
$$BuyYAmount = $$BuyYAmount + $value['Buy'][$SC]['Y']['Amount'];
$$BuyYTotalAmount = $$BuyYTotalAmount + $value['Buy'][$SC]['Y']['TotalAmount'];

	$SellNAmount = 'Sell'.$SC.'NAmount';
	$SellNTotalAmount = 'Sell'.$SC.'NTotalAmount';
	$SellYAmount = 'Sell'.$SC.'YAmount';
	$SellYTotalAmount = 'Sell'.$SC.'YTotalAmount';

$$SellNAmount = $$SellNAmount + $value['Sell'][$SC]['N']['Amount'];
$$SellNTotalAmount = $$SellNTotalAmount + $value['Sell'][$SC]['N']['TotalAmount'];
$$SellYAmount = $$SellYAmount + $value['Sell'][$SC]['Y']['Amount'];
$$SellYTotalAmount = $$SellYTotalAmount + $value['Sell'][$SC]['Y']['TotalAmount'];

}?>
	<tr>
		<th rowspan="2">Total</th>
		<th style="text-align:center " rowspan="2"><?=$users?></th>		
<?php foreach ($trades as $trade){
	$FC = strtoupper(substr($trade['trade'],0,3));
	$SC = strtoupper(substr($trade['trade'],4,3));
	$BuyNAmount = 'Buy'.$SC.'NAmount';
	$BuyNTotalAmount = 'Buy'.$SC.'NTotalAmount';
?>
		<th style="background-color:#B8EEB0"><?=$$BuyNAmount."/".$$BuyNTotalAmount?><br>
		<?php if($$BuyUSDNAmount!=0){echo number_format($$BuyNTotalAmount/$$BuyNAmount,4);}?>
		</th>				
<?php }?>
<?php foreach ($trades as $trade){
	$FC = strtoupper(substr($trade['trade'],0,3));
	$SC = strtoupper(substr($trade['trade'],4,3));
	$BuyYAmount = 'Buy'.$SC.'YAmount';
	$BuyYTotalAmount = 'Buy'.$SC.'YTotalAmount';
?>
		<th style="background-color:#D1F4CC"><?=$$BuyYAmount."/".$$BuyYTotalAmount?><br>
		<?php if($$BuyUSDYAmount!=0){echo number_format($$BuyYTotalAmount/$$BuyYAmount,4);}?>
		</th>
<?php }?>						
</tr><tr>
<?php foreach ($trades as $trade){
	$FC = strtoupper(substr($trade['trade'],0,3));
	$SC = strtoupper(substr($trade['trade'],4,3));
	$SellNAmount = 'Sell'.$SC.'NAmount';
	$SellNTotalAmount = 'Sell'.$SC.'NTotalAmount';
?>	
		<th style="background-color:#FEE1AF"><?=$$SellNAmount."/".$$SellNTotalAmount?><br>
		<?php if($$SellNAmount!=0){echo number_format($$SellNTotalAmount/$$SellNAmount,4);}?>
		</th>				
<? }?>		
<?php foreach ($trades as $trade){
	$FC = strtoupper(substr($trade['trade'],0,3));
	$SC = strtoupper(substr($trade['trade'],4,3));
	$SellYAmount = 'Sell'.$SC.'YAmount';
	$SellYTotalAmount = 'Sell'.$SC.'YTotalAmount';
?>	
		<th style="background-color:#FEEABA"><?=$$SellYAmount."/".$$SellYTotalAmount?><br>
		<?php if($$SellYAmount!=0){echo number_format($$SellYTotalAmount/$$SellYAmount,4);}?>
		</th>				
<? }?>		
	</tr>
	<tr>
		<th rowspan="3" style="text-align:center;">Date/Year</th>
		<th rowspan="3" style="text-align:center ">Users</th>
		<th colspan="6" style="text-align:center ;background-color:#D1F4CC">Buy</th>
		<th colspan="6" style="text-align:center ;background-color:#FEEABA">Sell</th>		
	</tr>	
	<tr>
		<th colspan="3" style="text-align:center ;background-color:#B8EEB0">Pending</th>
		<th colspan="3" style="text-align:center ;background-color:#D1F4CC">Complete</th>		
		<th colspan="3" style="text-align:center ;background-color:#FEE1AF">Pending</th>
		<th colspan="3" style="text-align:center ;background-color:#FEEABA">Complete</th>		
	</tr>
	<tr>
		<th style="text-align:center ;background-color:#B8EEB0">BTC/USD</th>
		<th style="text-align:center ;background-color:#B8EEB0">BTC/GBP</th>		
		<th style="text-align:center ;background-color:#B8EEB0">BTC/EUR</th>		
		<th style="text-align:center ;background-color:#D1F4CC">BTC/USD</th>
		<th style="text-align:center ;background-color:#D1F4CC">BTC/GBP</th>		
		<th style="text-align:center ;background-color:#D1F4CC">BTC/EUR</th>		
		<th style="text-align:center ;background-color:#FEE1AF">BTC/USD</th>
		<th style="text-align:center ;background-color:#FEE1AF">BTC/GBP</th>		
		<th style="text-align:center ;background-color:#FEE1AF">BTC/EUR</th>		
		<th style="text-align:center ;background-color:#FEEABA">BTC/USD</th>
		<th style="text-align:center ;background-color:#FEEABA">BTC/GBP</th>		
		<th style="text-align:center ;background-color:#FEEABA">BTC/EUR</th>		
	</tr>
	<?php 
foreach($newYear as $key=>$value){
	?>
	<tr>
		<td><?=$key;?></td>
		<td style="text-align:center "><?=$value['Register']?>&nbsp;</td>
		<td style=" background-color:#B8EEB0 "><?php if(count($value['Buy']['USD']['N'])>0){?><?php echo $value['Buy']['USD']['N']['Amount']."/".$value['Buy']['USD']['N']['TotalAmount'];?><br><small>
		<?php echo number_format($value['Buy']['USD']['N']['TotalAmount']/$value['Buy']['USD']['N']['Amount'],4);?>
		</small>
&nbsp;<?php }?></td>				
		<td style=" background-color:#B8EEB0 "><?php if(count($value['Buy']['GBP']['N'])>0){?><?php echo $value['Buy']['GBP']['N']['Amount']."/".$value['Buy']['GBP']['N']['TotalAmount'];?><br><small>
		<?php echo number_format($value['Buy']['GBP']['N']['TotalAmount']/$value['Buy']['GBP']['N']['Amount'],4);?>
		</small>
&nbsp;<?php }?></td>				
		<td style=" background-color:#B8EEB0 "><?php if(count($value['Buy']['EUR']['N'])>0){?><?php echo $value['Buy']['EUR']['N']['Amount']."/".$value['Buy']['EUR']['N']['TotalAmount'];?><br><small>
		<?php echo number_format($value['Buy']['EUR']['N']['TotalAmount']/$value['Buy']['EUR']['N']['Amount'],4);?>
		</small>
&nbsp;<?php }?></td>				


		<td style=";background-color:#D1F4CC "><?php if(count($value['Buy']['USD']['Y'])>0){?><?php echo $value['Buy']['USD']['Y']['Amount']."/".$value['Buy']['USD']['Y']['TotalAmount'];?><br><small>
		<?php echo number_format($value['Buy']['USD']['Y']['TotalAmount']/$value['Buy']['USD']['Y']['Amount'],4);?>
		</small>
&nbsp;<?php }?></td>				
		<td style=";background-color:#D1F4CC "><?php if(count($value['Buy']['GBP']['Y'])>0){?><?php echo $value['Buy']['GBP']['Y']['Amount']."/".$value['Buy']['GBP']['Y']['TotalAmount'];?><br><small>
		<?php echo number_format($value['Buy']['GBP']['Y']['TotalAmount']/$value['Buy']['GBP']['Y']['Amount'],4);?>
		</small>
&nbsp;<?php }?></td>				
		<td style=";background-color:#D1F4CC "><?php if(count($value['Buy']['EUR']['Y'])>0){?><?php echo $value['Buy']['EUR']['Y']['Amount']."/".$value['Buy']['EUR']['Y']['TotalAmount'];?><br><small>
		<?php echo number_format($value['Buy']['EUR']['Y']['TotalAmount']/$value['Buy']['EUR']['Y']['Amount'],4);?>
		</small>
&nbsp;<?php }?></td>				



		<td style="background-color:#FEE1AF "><?php if(count($value['Sell']['USD']['N'])>0){?><?php echo $value['Sell']['USD']['N']['Amount']."/".$value['Sell']['USD']['N']['TotalAmount'];?><br><small>
		<?php echo number_format($value['Sell']['USD']['N']['TotalAmount']/$value['Sell']['USD']['N']['Amount'],4);?>
		</small>
&nbsp;<?php }?></td>				
		<td style="background-color:#FEE1AF "><?php if(count($value['Sell']['GBP']['N'])>0){?><?php echo $value['Sell']['GBP']['N']['Amount']."/".$value['Sell']['GBP']['N']['TotalAmount'];?><br><small>
		<?php echo number_format($value['Sell']['GBP']['N']['TotalAmount']/$value['Sell']['GBP']['N']['Amount'],4);?>
		</small>
&nbsp;<?php }?></td>				
		<td style="background-color:#FEE1AF "><?php if(count($value['Sell']['EUR']['N'])>0){?><?php echo $value['Sell']['EUR']['N']['Amount']."/".$value['Sell']['EUR']['N']['TotalAmount'];?><br><small>
		<?php echo number_format($value['Sell']['EUR']['N']['TotalAmount']/$value['Sell']['EUR']['N']['Amount'],4);?>
		</small>
&nbsp;<?php }?></td>				


		<td style="background-color:#FEEABA "><?php if(count($value['Sell']['USD']['Y'])>0){?><?php echo $value['Sell']['USD']['Y']['Amount']."/".$value['Sell']['USD']['Y']['TotalAmount'];?><br><small>
		<?php echo number_format($value['Sell']['USD']['Y']['TotalAmount']/$value['Sell']['USD']['Y']['Amount'],4);?>
		</small>
&nbsp;<?php }?></td>				
		<td style="background-color:#FEEABA "><?php if(count($value['Sell']['GBP']['Y'])>0){?><?php echo $value['Sell']['GBP']['Y']['Amount']."/".$value['Sell']['GBP']['Y']['TotalAmount'];?><br><small>
		<?php echo number_format($value['Sell']['GBP']['Y']['TotalAmount']/$value['Sell']['GBP']['Y']['Amount'],4);?>
		</small>
&nbsp;<?php }?></td>				
		<td style="background-color:#FEEABA "><?php if(count($value['Sell']['EUR']['Y'])>0){?><?php echo $value['Sell']['EUR']['Y']['Amount']."/".$value['Sell']['EUR']['Y']['TotalAmount'];?><br><small>
		<?php echo number_format($value['Sell']['EUR']['Y']['TotalAmount']/$value['Sell']['EUR']['Y']['Amount'],4);?>
		</small>
&nbsp;<?php }?></td>				
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