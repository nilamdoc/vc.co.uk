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
						<td style=" background-color:#B8EEB0 "><?php if(count($value['Buy'][$trade['trade']]['N'])>0){?><?php echo number_format($value['Buy'][$trade['trade']]['N']['Amount'],4)."/".number_format($value['Buy'][$trade['trade']]['N']['TotalAmount'],2);?><br><small>
						<?php echo number_format($value['Buy'][$trade['trade']]['N']['TotalAmount']/$value['Buy'][$trade['trade']]['N']['Amount'],2);?>
						</small>
				&nbsp;<?php }?></td>				
				<?php }?>
			<!--Buy-Pending-->
			<!--Buy-Complete-->
				<?php foreach ($trades as $trade){
					$FC = strtoupper(substr($trade['trade'],0,3));
					$SC = strtoupper(substr($trade['trade'],4,3));
				?>
					<td style=";background-color:#D1F4CC "><?php if(count($value['Buy'][$trade['trade']]['Y'])>0){?><?php echo number_format($value['Buy'][$trade['trade']]['Y']['Amount'],4)."/".number_format($value['Buy'][$trade['trade']]['Y']['TotalAmount'],2);?><br><small>
					<?php echo number_format($value['Buy'][$trade['trade']]['Y']['TotalAmount']/$value['Buy'][$trade['trade']]['Y']['Amount'],2);?>
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
					<td style="background-color:#FEE1AF "><?php if(count($value['Sell'][$trade['trade']]['N'])>0){?><?php echo  number_format($value['Sell'][$trade['trade']]['N']['Amount'],4)."/". number_format($value['Sell'][$trade['trade']]['N']['TotalAmount'],2);?><br><small>
					<?php echo number_format($value['Sell'][$trade['trade']]['N']['TotalAmount']/$value['Sell'][$trade['trade']]['N']['Amount'],2);?>
					</small>
			&nbsp;<?php }?></td>				
				<?php }?>
			<!--Sell-Pending-->
			<!--Sell-Complete-->
				<?php foreach ($trades as $trade){
					$FC = strtoupper(substr($trade['trade'],0,3));
					$SC = strtoupper(substr($trade['trade'],4,3));
				?>
					<td style="background-color:#FEEABA "><?php if(count($value['Sell'][$trade['trade']]['Y'])>0){?><?php  echo number_format($value['Sell'][$trade['trade']]['Y']['Amount'],4)."/". number_format($value['Sell'][$trade['trade']]['Y']['TotalAmount'],2);?><br><small>
					<?php echo number_format($value[$trade['trade']]['USD']['Y']['TotalAmount']/$value[$trade['trade']]['USD']['Y']['Amount'],2);?>
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
		
			$BuyNAmount = 'Buy'.$FC.'_'.$SC.'NAmount';
			$BuyNTotalAmount = 'Buy'.$FC.'_'.$SC.'NTotalAmount';
			$BuyYAmount = 'Buy'.$FC.'_'.$SC.'YAmount';
			$BuyYTotalAmount = 'Buy'.$FC.'_'.$SC.'YTotalAmount';
				
			$$BuyNAmount = $$BuyNAmount + $value['Buy'][$trade['trade']]['N']['Amount'];
			$$BuyNTotalAmount = $$BuyNTotalAmount + $value['Buy'][$trade['trade']]['N']['TotalAmount'];
			$$BuyYAmount = $$BuyYAmount + $value['Buy'][$trade['trade']]['Y']['Amount'];
			$$BuyYTotalAmount = $$BuyYTotalAmount + $value['Buy'][$trade['trade']]['Y']['TotalAmount'];
				
			$SellNAmount = 'Sell'.$FC.'_'.$SC.'NAmount';
			$SellNTotalAmount = 'Sell'.$FC.'_'.$SC.'NTotalAmount';
			$SellYAmount = 'Sell'.$FC.'_'.$SC.'YAmount';
			$SellYTotalAmount = 'Sell'.$FC.'_'.$SC.'YTotalAmount';
				
			$$SellNAmount = $$SellNAmount + $value['Sell'][$trade['trade']]['N']['Amount'];
			$$SellNTotalAmount = $$SellNTotalAmount + $value['Sell'][$trade['trade']]['N']['TotalAmount'];
			$$SellYAmount = $$SellYAmount + $value['Sell'][$trade['trade']]['Y']['Amount'];
			$$SellYTotalAmount = $$SellYTotalAmount + $value['Sell'][$trade['trade']]['Y']['TotalAmount'];
		}
		?>
<?php }?>
<tr>
<th rowspan="2">Total</th>
<th style="text-align:center " rowspan="2"><?=$users?></th>		
	<?php foreach ($trades as $trade){
		$FC = strtoupper(substr($trade['trade'],0,3));
		$SC = strtoupper(substr($trade['trade'],4,3));
		$BuyNAmount = 'Buy'.$FC.'_'.$SC.'NAmount';
		$BuyNTotalAmount = 'Buy'.$FC.'_'.$SC.'NTotalAmount';
	?>
			<th style="background-color:#B8EEB0"><?= number_format($$BuyNAmount,2)."/". number_format($$BuyNTotalAmount,2)?><br>
			<?php if($$BuyUSDNAmount!=0){echo number_format($$BuyNTotalAmount/$$BuyNAmount,2);}?>
			</th>				
	<?php }?>
	<?php foreach ($trades as $trade){
		$FC = strtoupper(substr($trade['trade'],0,3));
		$SC = strtoupper(substr($trade['trade'],4,3));
		$BuyYAmount = 'Buy'.$FC.'_'.$SC.'YAmount';
		$BuyYTotalAmount = 'Buy'.$FC.'_'.$SC.'YTotalAmount';
	?>
			<th style="background-color:#D1F4CC"><?= number_format($$BuyYAmount,2)."/". number_format($$BuyYTotalAmount,2)?><br>
			<?php if($$BuyUSDYAmount!=0){echo number_format($$BuyYTotalAmount/$$BuyYAmount,2);}?>
			</th>
	<?php }?>						
</tr><tr>
	<?php foreach ($trades as $trade){
		$FC = strtoupper(substr($trade['trade'],0,3));
		$SC = strtoupper(substr($trade['trade'],4,3));
		$SellNAmount = 'Sell'.$FC.'_'.$SC.'NAmount';
		$SellNTotalAmount = 'Sell'.$FC.'_'.$SC.'NTotalAmount';
	?>	
			<th style="background-color:#FEE1AF"><?= number_format($$SellNAmount,2)."/". number_format($$SellNTotalAmount,2)?><br>
			<?php if($$SellNAmount!=0){echo number_format($$SellNTotalAmount/$$SellNAmount,2);}?>
			</th>				
	<?php }?>		
	<?php foreach ($trades as $trade){
		$FC = strtoupper(substr($trade['trade'],0,3));
		$SC = strtoupper(substr($trade['trade'],4,3));
		$SellYAmount = 'Sell'.$FC.'_'.$SC.'YAmount';
		$SellYTotalAmount = 'Sell'.$FC.'_'.$SC.'YTotalAmount';
	?>	
			<th style="background-color:#FEEABA"><?= number_format($$SellYAmount,2)."/". number_format($$SellYTotalAmount,2)?><br>
			<?php if($$SellYAmount!=0){echo number_format($$SellYTotalAmount/$$SellYAmount,2);}?>
			</th>				
	<?php }?>		
	</tr>
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
	</tr>		<?php 
foreach($newYear as $key=>$value){
	?>
	<tr>
		<td rowspan="2"><?=$key;?></td>
		<td style="text-align:center " rowspan="2"><?=$value['Register']?>&nbsp;</td>
			<!--Buy-Pending--->
				<?php foreach ($trades as $trade){
					$FC = strtoupper(substr($trade['trade'],0,3));
					$SC = strtoupper(substr($trade['trade'],4,3));
				?>
						<td style=" background-color:#B8EEB0 "><?php if(count($value['Buy'][$trade['trade']]['N'])>0){?><?php echo number_format($value['Buy'][$trade['trade']]['N']['Amount'],4)."/".number_format($value['Buy'][$trade['trade']]['N']['TotalAmount'],2);?><br><small>
						<?php echo number_format($value['Buy'][$trade['trade']]['N']['TotalAmount']/$value['Buy'][$trade['trade']]['N']['Amount'],2);?>
						</small>
				&nbsp;<?php }?></td>				
				<?php }?>
			<!--Buy-Pending-->
			<!--Buy-Complete-->
				<?php foreach ($trades as $trade){
					$FC = strtoupper(substr($trade['trade'],0,3));
					$SC = strtoupper(substr($trade['trade'],4,3));
				?>
					<td style=";background-color:#D1F4CC "><?php if(count($value['Buy'][$trade['trade']]['Y'])>0){?><?php echo number_format($value['Buy'][$trade['trade']]['Y']['Amount'],4)."/".number_format($value['Buy'][$trade['trade']]['Y']['TotalAmount'],2);?><br><small>
					<?php echo number_format($value['Buy'][$trade['trade']]['Y']['TotalAmount']/$value['Buy'][$trade['trade']]['Y']['Amount'],2);?>
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
					<td style="background-color:#FEE1AF "><?php if(count($value['Sell'][$trade['trade']]['N'])>0){?><?php echo  number_format($value['Sell'][$trade['trade']]['N']['Amount'],4)."/". number_format($value['Sell'][$trade['trade']]['N']['TotalAmount'],2);?><br><small>
					<?php echo number_format($value['Sell'][$trade['trade']]['N']['TotalAmount']/$value['Sell'][$trade['trade']]['N']['Amount'],2);?>
					</small>
			&nbsp;<?php }?></td>				
				<?php }?>
			<!--Sell-Pending-->
			<!--Sell-Complete-->
				<?php foreach ($trades as $trade){
					$FC = strtoupper(substr($trade['trade'],0,3));
					$SC = strtoupper(substr($trade['trade'],4,3));
				?>
					<td style="background-color:#FEEABA "><?php if(count($value['Sell'][$trade['trade']]['Y'])>0){?><?php  echo number_format($value['Sell'][$trade['trade']]['Y']['Amount'],4)."/". number_format($value['Sell'][$trade['trade']]['Y']['TotalAmount'],2);?><br><small>
					<?php echo number_format($value[$trade['trade']]['USD']['Y']['TotalAmount']/$value[$trade['trade']]['USD']['Y']['Amount'],2);?>
					</small>
			&nbsp;<?php }?></td>				
				<?php }?>
			<!--Sell-Complete-->
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
<br>
<br>
<br>
<br>

</div>
<script src="/js/admin.js"></script>