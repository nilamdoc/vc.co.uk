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
foreach($new as $key=>$value){
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
<?php  
$users = $users + $value['Register'];
$BuyUSDNAmount = $BuyUSDNAmount + $value['Buy']['USD']['N']['Amount'];
$BuyUSDNTotalAmount = $BuyUSDNTotalAmount + $value['Buy']['USD']['N']['TotalAmount'];

$BuyGBPNAmount = $BuyGBPNAmount + $value['Buy']['GBP']['N']['Amount'];
$BuyGBPNTotalAmount = $BuyGBPNTotalAmount + $value['Buy']['GBP']['N']['TotalAmount'];

$BuyEURNAmount = $BuyEURNAmount + $value['Buy']['EUR']['N']['Amount'];
$BuyEURNTotalAmount = $BuyEURNTotalAmount + $value['Buy']['EUR']['N']['TotalAmount'];

$BuyUSDYAmount = $BuyUSDYAmount + $value['Buy']['USD']['Y']['Amount'];
$BuyUSDYTotalAmount = $BuyUSDYTotalAmount + $value['Buy']['USD']['Y']['TotalAmount'];

$BuyGBPYAmount = $BuyGBPYAmount + $value['Buy']['GBP']['Y']['Amount'];
$BuyGBPYTotalAmount = $BuyGBPYTotalAmount + $value['Buy']['GBP']['Y']['TotalAmount'];

$BuyEURYAmount = $BuyEURYAmount + $value['Buy']['EUR']['Y']['Amount'];
$BuyEURYTotalAmount = $BuyEURYTotalAmount + $value['Buy']['EUR']['Y']['TotalAmount'];



$SellUSDNAmount = $SellUSDNAmount + $value['Sell']['USD']['N']['Amount'];
$SellUSDNTotalAmount = $SellUSDNTotalAmount + $value['Sell']['USD']['N']['TotalAmount'];

$SellGBPNAmount = $SellGBPNAmount + $value['Sell']['GBP']['N']['Amount'];
$SellGBPNTotalAmount = $SellGBPNTotalAmount + $value['Sell']['GBP']['N']['TotalAmount'];

$SellEURNAmount = $SellEURNAmount + $value['Sell']['EUR']['N']['Amount'];
$SellEURNTotalAmount = $SellEURNTotalAmount + $value['Sell']['EUR']['N']['TotalAmount'];

$SellUSDYAmount = $SellUSDYAmount + $value['Sell']['USD']['Y']['Amount'];
$SellUSDYTotalAmount = $SellUSDYTotalAmount + $value['Sell']['USD']['Y']['TotalAmount'];

$SellGBPYAmount = $SellGBPYAmount + $value['Sell']['GBP']['Y']['Amount'];
$SellGBPYTotalAmount = $SellGBPYTotalAmount + $value['Sell']['GBP']['Y']['TotalAmount'];

$SellEURYAmount = $SellEURYAmount + $value['Sell']['EUR']['Y']['Amount'];
$SellEURYTotalAmount = $SellEURYTotalAmount + $value['Sell']['EUR']['Y']['TotalAmount'];

}?>
	<tr>
		<th>Total</th>
		<th style="text-align:center "><?=$users?></th>		
		<th style="background-color:#B8EEB0"><?=$BuyUSDNAmount."/".$BuyUSDNTotalAmount?><br>
		<?php if($BuyUSDNAmount!=0){echo number_format($BuyUSDNTotalAmount/$BuyUSDNAmount,4);}?>
		</th>				
		<th style="background-color:#B8EEB0"><?=$BuyGBPNAmount."/".$BuyGBPNTotalAmount?><br>
		<?php if($BuyUSDNAmount!=0){echo number_format($BuyUSDNTotalAmount/$BuyUSDNAmount,4);}?>
		</th>				
		<th style="background-color:#B8EEB0"><?=$BuyEURNAmount."/".$BuyEURNTotalAmount?><br>
		<?php if($BuyEURNAmount!=0){echo number_format($BuyEURNTotalAmount/$BuyEURNAmount,4);}?>
		</th>				
		<th style="background-color:#D1F4CC"><?=$BuyUSDYAmount."/".$BuyUSDYTotalAmount?><br>
		<?php if($BuyUSDYAmount!=0){echo number_format($BuyUSDYTotalAmount/$BuyUSDYAmount,4);}?>
		</th>				
		<th style="background-color:#D1F4CC"><?=$BuyGBPYAmount."/".$BuyGBPYTotalAmount?><br>
		<?php if($BuyGBPYAmount!=0){echo number_format($BuyGBPYTotalAmount/$BuyGBPYAmount,4);}?>
		</th>				
		<th style="background-color:#D1F4CC"><?=$BuyEURYAmount."/".$BuyEURYTotalAmount?><br>
		<?php if($BuyEURYAmount!=0){echo number_format($BuyEURYTotalAmount/$BuyEURYAmount,4);}?>
		</th>						

		<th style="background-color:#FEE1AF"><?=$SellUSDNAmount."/".$SellUSDNTotalAmount?><br>
		<?php if($SellUSDNAmount!=0){echo number_format($SellUSDNTotalAmount/$SellUSDNAmount,4);}?>
		</th>				
		<th style="background-color:#FEE1AF"><?=$SellGBPNAmount."/".$SellGBPNTotalAmount?><br>
		<?php if($SellUSDNAmount!=0){echo number_format($SellUSDNTotalAmount/$SellUSDNAmount,4);}?>
		</th>				
		<th style="background-color:#FEE1AF"><?=$SellEURNAmount."/".$SellEURNTotalAmount?><br>
		<?php if($SellEURNAmount!=0){echo number_format($SellEURNTotalAmount/$SellEURNAmount,4);}?>
		</th>				
		<th style="background-color:#FEEABA"><?=$SellUSDYAmount."/".$SellUSDYTotalAmount?><br>
		<?php if($SellUSDYAmount!=0){echo number_format($SellUSDYTotalAmount/$SellUSDYAmount,4);}?>
		</th>				
		<th style="background-color:#FEEABA"><?=$SellGBPYAmount."/".$SellGBPYTotalAmount?><br>
		<?php if($SellGBPYAmount!=0){echo number_format($SellGBPYTotalAmount/$SellGBPYAmount,4);}?>
		</th>				
		<th style="background-color:#FEEABA"><?=$SellEURYAmount."/".$SellEURYTotalAmount?><br>
		<?php if($SellEURYAmount!=0){echo number_format($SellEURYTotalAmount/$SellEURYAmount,4);}?>
		</th>						
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