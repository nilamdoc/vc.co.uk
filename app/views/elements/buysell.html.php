<?php
use lithium\util\String;

$sel_curr = $this->_request->params['args'][0];

$first_curr = strtoupper(substr($sel_curr,0,3));
$second_curr = strtoupper(substr($sel_curr,4,3));
$BTC = $details['balance']['BTC'];
$LTC = $details['balance']['LTC'];
$USD = $details['balance']['USD'];
$GBP = $details['balance']['GBP'];
$EUR = $details['balance']['EUR'];
$BalanceFirst = 0;
$BalanceSecond = 0;
switch ($first_curr) {
    case "BTC":
    $BalanceFirst = $BTC;
        break;
    case "LTC":
		$BalanceFirst = $LTC;
        break;
    case "USD":
		$BalanceFirst = $USD;
        break;
    case "GBP":
		$BalanceFirst = $GBP;
        break;
    case "EUR":
		$BalanceFirst = $EUR;
        break;
}
if (is_null($BalanceFirst)){$BalanceFirst = 0;}
switch ($second_curr) {
    case "BTC":
    $BalanceSecond = $BTC;
        break;
    case "LTC":
		$BalanceSecond = $LTC;
        break;
    case "USD":
		$BalanceSecond = $USD;
        break;
    case "GBP":
		$BalanceSecond = $GBP;
        break;
    case "EUR":
		$BalanceSecond = $EUR;
        break;
}
if (is_null($BalanceSecond)){$BalanceSecond = 0;}
?>
<?php use lithium\core\Environment; 
if(Environment::get('locale')=="en_US"){$locale = "en";}else{$locale = Environment::get('locale');}
?>
<div style="background-image:url(/img/Stamp.png);background-position:bottom right;background-repeat:no-repeat">
<div id="User_ID" style="display:none "><?=$details['user_id']?></div>
<div class="row" >

<div class="span8" id="Graph" style="text-aligh:center;display:none" >
		<div class="navbar">
			<div class="navbar-inner">
			<a class="brand" href="#" onclick="document.getElementById('Graph').style.display='none';">Graph
				<i class="icon-remove"></i>
			</a>
			</div>
		</div>
		<div style="padding-bottom:15px;padding-left:10px;margin-top:-20px">
		<img src="/documents/<?=$first_curr?>_<?=$second_curr?>.png"><br>
		<img src="/documents/<?=$first_curr?>_<?=$second_curr?>-T.png">		
		</div>
</div>
<?php 
if($$second_curr!=0){ ?>
	<div class="span4">
		<div class="navbar">
			<div class="navbar-inner">
			<a class="brand" href="#"  onclick="document.getElementById('Graph').style.display='block';"><?=$t('Buy')?> <?=$first_curr?> <?=$t("with")?> <?=$second_curr?> <i class="icon-indent-left"></i></a>
			</div>
		</div>
		<?=$this->form->create(null); ?>
		<input type="hidden" id="BuyFirstCurrency" name="BuyFirstCurrency" value="<?=$first_curr?>">
		<input type="hidden" id="BuySecondCurrency" name="BuySecondCurrency" value="<?=$second_curr?>">		
		<input type="hidden" id="BuyCommission" name="BuyCommission" value="0">
		<input type="hidden" id="BuyCommissionAmount" name="BuyCommissionAmount" value="0">
		<input type="hidden" id="BuyCommissionCurrency" name="BuyCommissionCurrency" value="0">		
		<input type="hidden" id="Action" name="Action" value="Buy">						
		<table class="table table-condensed table-bordered table-hover" style="margin-top:-20px">
			<tr>
				<td><?=$t('Your balance')?>:<br>
					<span class="btn btn-info" style="width:80% "><span id="BalanceSecond"><?=$BalanceSecond?></span> <?=$second_curr?></span>
				</td>
				<td><?=$t('Lowest Ask Price')?><br>
					<span class="btn btn-warning" style="width:80% "><span id="LowestAskPrice">0</span> <?=$second_curr?></span>
				</td>
			</tr>
			<tr>
				<td>
				<?=$this->form->field('BuyAmount', array('label'=>'Amount '.$first_curr,'class'=>'span1', 'value'=>0, 'onBlur'=>'$("#BuySubmitButton").attr("disabled", "disabled");','min'=>'0','max'=>'99999999','maxlength'=>'10')); ?>				
				</td>
				<td>
				<div class="input-append">
					<label for="BuyPriceper"><?=$t("Price per ")?><?=$first_curr?></label>
					<input class="span1" id="BuyPriceper" name="BuyPriceper" type="text" onBlur='$("#BuySubmitButton").attr("disabled", "disabled");' min="0" max="99999999" maxlength="10">
					<span class="add-on"> <strong><?=$second_curr?></strong></span>
				</div>				
				</td>				
			</tr>
			<tr>
				<td>Total: </td>
				<td> <span class="label label-important"><span id="BuyTotal">0</span> <?=$second_curr?></span></td>
			</tr>
			<tr>
				<td>Fees: </td>
				<td> <span class="label label-success"><span id="BuyFee">0</span> <?=$first_curr?></span></td>
			</tr>
			<tr>
				<td colspan="2"  style="height:50px "><span id="BuySummary"><?=$t('Summary of your order')?></span></td>
			</tr>
			<tr>
				<td><input type="button" onClick="BuyFormCalculate()" class="btn" value="Calculate"></td>
				<td><input type="submit" id="BuySubmitButton" class="btn btn-primary" disabled="disabled" value="Submit" onclick="document.getElementById('BuySubmitButton').disabled = true;"></td>
			</tr>
		</table>
		<?=$this->form->end(); ?>
	</div>
<?php }else{?>
	<div class="span4">
		<div class="navbar">
			<div class="navbar-inner">
			<a class="brand" href="#"  onclick="document.getElementById('Graph').style.display='block';">No funds in <?=$second_curr?>  <i class="icon-indent-left"></i></a>
			</div>
		<table class="table table-condensed table-bordered table-hover" style="margin-top:-20px;height:288px">
			<tr>
				<td>
					You should verify:
				</td>
			</tr>
			<tr>
				<td>
	<?php if(strlen($details['bank.verified'])==0){	?>
							<a href="/users/settings/bank" class="label label-warning tooltip-x" rel="tooltip-x" data-placement="top" title="Compulsary to transact!"><i class="icon-remove icon-black"></i> <?=$t("Bank Account")?></a>
						<?php }elseif($details['bank.verified']=='No'){?>
							<a href="#" class="label label-important tooltip-x" rel="tooltip-x" data-placement="top" title="Pending verification!"><i class="icon-edit icon-black"></i> <?=$t("Bank Account")?></a>
						<?php }else{ ?>
							<a href="#" class="label label-success tooltip-x" rel="tooltip-x" data-placement="top" title="Completed!"><i class="icon-ok icon-black"></i> <?=$t("Bank Account")?></a>					
						<?php }	?>				
				</td>
			</tr>
			<tr>
				<td>
					<?php 
					if(strlen($details['government.verified'])==0){
					?>
						<a href="/users/settings/government" class="label label-warning tooltip-x" rel="tooltip-x" data-placement="top" title="Compulsary to transact!"><i class="icon-remove icon-black"></i> <?=$t("Government Photo ID")?></a>
					<?php }elseif($details['government.verified']=='No'){?>
						<a href="#" class="label label-important tooltip-x" rel="tooltip-x" data-placement="top" title="Pending verification!"><i class="icon-edit icon-black"></i> <?=$t("Government Photo ID")?></a>
					<?php }else{ ?>
						<a href="#" class="label label-success tooltip-x" rel="tooltip-x" data-placement="top" title="Completed!"><i class="icon-ok icon-black"></i> <?=$t("Government ID")?></a>					
					<?php }	?>
				</td>
			</tr>
			<tr>
				<td>
					<?php 
					if(strlen($details['utility.verified'])==0){
					?>
						<a href="/users/settings/utility" class="label label-warning tooltip-x" rel="tooltip-x" data-placement="top" title="Compulsary to transact!"><i class="icon-remove icon-black"></i> <?=$t("Proof of Address")?></a>
					<?php }elseif($details['utility.verified']=='No'){?>
						<a href="#" class="label label-important tooltip-x" rel="tooltip-x" data-placement="top" title="Pending verification!"><i class="icon-edit icon-black"></i> <?=$t("Proof of Address")?></a>
					<?php }else{ ?>
						<a href="#" class="label label-success tooltip-x" rel="tooltip-x" data-placement="top" title="Completed!"><i class="icon-ok icon-black"></i> <?=$t("Proof of Address")?></a>					
					<?php }	?>
				</td>
			</tr>
			<tr>
			<td>Add BTC/LTC or Fiat currency through the links below:<br>
				<a href="/users/funding_btc" class="btn btn-primary"><?=$t("Funding BTC")?></a>
				<a href="/users/funding_ltc" class="btn btn-primary"><?=$t("Funding LTC")?></a>				
				<a href="/users/funding_fiat" class="btn btn-primary"><?=$t("Funding Fiat")?></a>								
			</td>
			</tr>
		</table>			
		</div>
	</div>
<?php }?>	
<?php if($$first_curr!=0){ ?>
	<div class="span4">
		<div class="navbar">
			<div class="navbar-inner">
			<a class="brand" href="#"  onclick="document.getElementById('Graph').style.display='block';"><?=$t('Sell')?> <?=$first_curr?> <?=$t("get")?> <?=$second_curr?> <i class="icon-indent-left"></i></a>
			</div>
		</div>
		<?=$this->form->create(null); ?>		
		<input type="hidden" id="SellFirstCurrency" name="SellFirstCurrency" value="<?=$first_curr?>">
		<input type="hidden" id="SellSecondCurrency" name="SellSecondCurrency" value="<?=$second_curr?>">		
		<input type="hidden" id="SellCommission" name="SellCommission" value="0">				
		<input type="hidden" id="SellCommissionAmount" name="SellCommissionAmount" value="0">						
		<input type="hidden" id="SellCommissionCurrency" name="SellCommissionCurrency" value="0">								
		<input type="hidden" id="Action" name="Action" value="Sell">								
		<table class="table table-condensed table-bordered table-hover" style="margin-top:-20px">
			<tr>
			<td><?=$t('Your balance')?>:<br>
			<span class="btn btn-info " style="width:80%"><span id="BalanceFirst"><?=$BalanceFirst?></span> <?=$first_curr?></span>
			</td>
			<td><?=$t('Highest Bid Price')?><br>
				<span class="btn btn-success " style="width:80%"><span id="HighestBidPrice">0</span> <?=$second_curr?></span>
			</td>
			</tr>
			<tr>
				<td>
				<?=$this->form->field('SellAmount', array('label'=>'Amount '.$first_curr,'class'=>'span1', 'value'=>0, 'onBlur'=>'$("#SellSubmitButton").attr("disabled", "disabled");','min'=>'0','max'=>'99999999','maxlength'=>'10')); ?>				
				</td>
				<td>
				<div class="input-append">
					<label for="SellPriceper"><?=$t("Price per ")?><?=$first_curr?></label>
					<input class="span1" id="SellPriceper" name="SellPriceper" type="text"  onBlur='$("#SellSubmitButton").attr("disabled", "disabled");' min="0" max="99999999" maxlength="10">
					<span class="add-on"> <strong><?=$second_curr?></strong></span>
				</div>				
				</td>				
			</tr>
			<tr>
				<td>Total: </td>
				<td> <span class="label label-important"><span id="SellTotal">0</span> <?=$second_curr?></span></td>
			</tr>
			<tr>
				<td>Fees: </td>
				<td> <span class="label label-success"><span id="SellFee">0</span> <?=$second_curr?></span></td>
			</tr>
			<tr>
				<td colspan="2" style="height:50px "><span id="SellSummary"><?=$t('Summary of your order')?></span></td>
			</tr>
			<tr>
				<td><input type="button" onClick="SellFormCalculate()" class="btn" value="Calculate"></td>
				<td><input type="submit" id="SellSubmitButton" class="btn btn-primary" disabled="disabled" value="Submit" onClick="document.getElementById('SellSubmitButton').disabled = true;"></td>
			</tr>
		</table>
		<?=$this->form->end(); ?>		
	</div>
	<?php }else{?>
	<div class="span4">
		<div class="navbar">
			<div class="navbar-inner">
			<a class="brand" href="#"  onclick="document.getElementById('Graph').style.display='block';">No funds in <?=$first_curr?> <i class="icon-indent-left"></i></a>
			</div>
		</div>
		<table class="table table-condensed table-bordered table-hover" style="margin-top:-20px;height:288px">
			<tr>
				<td>
				Add BTC/LTC or Fiat currency through the link below:<br>
				<a href="/users/funding_btc" class="btn btn-primary"><?=$t("Funding BTC")?></a>
				<a href="/users/funding_ltc" class="btn btn-primary"><?=$t("Funding LTC")?></a>				
				<a href="/users/funding_fiat" class="btn btn-primary"><?=$t("Funding Fiat")?></a>								
				</td>
			</tr>
		</table>		
	</div>
	<?php }?>
	<div class="span3"  style="height:314px;">
		<div class="navbar">
			<div class="navbar-inner">
			<a class="brand" href="#"  onclick="document.getElementById('Graph').style.display='block';"><?=$t('Pending orders')?> <i class="icon-indent-left"></i></a>
			</div>
			<div id="YourOrders" style="height:280px;overflow:auto;">			
			<table class="table table-condensed table-bordered table-hover" style="font-size:11px">
				<thead>
					<tr>
						<th style="text-align:center "><?=$t('Exchange')?></th>
						<th style="text-align:center "><?=$t('Price')?></th>
						<th style="text-align:center "><?=$t('Amount')?></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach($YourOrders as $YO){ ?>
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
	</div>
</div>
<div class="row">
	<div class="span4" style="border:1px solid gray;">
		<div class="navbar">
			<div class="navbar-inner">
			<a class="brand" href="#"><?=$t('Orders:')?>
			<small><?=$t('Sell')?> <?=$first_curr?> &gt; <?=$second_curr?></small></a>
<?php 
 foreach($TotalSellOrders['result'] as $TSO){
	$SellAmount = $TSO['Amount'];
	$SellTotalAmount = $TSO['TotalAmount'];
}?>			
			</div>
		</div>
		<div id="SellOrders" style="height:300px;overflow:auto;margin-top:-20px ">
			<table class="table table-condensed table-bordered table-hover" style="font-size:12px ">
				<thead>
					<tr>
					<th style="text-align:center " rowspan="2">#</th>					
					<th style="text-align:center " ><?=$t('Price')?></th>
					<th style="text-align:center " ><?=$first_curr?></th>
					<th style="text-align:center " ><?=$second_curr?></th>					
					</tr>
					<tr>
					<th style="text-align:center " ><?=$t('Total')?> &raquo;</th>
					<th style="text-align:right " ><?=number_format($SellAmount,8)?></th>
					<th style="text-align:right " ><?=number_format($SellTotalAmount,8)?></th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$SellOrderAmount = 0;
					foreach($SellOrders['result'] as $SO){
						$SellOrderPrice = number_format(round($SO['_id']['PerPrice'],8),8);
						$SellOrderAmount = number_format(round($SO['Amount'],8),8);
					?>
					<tr onClick="SellOrderFill(<?=$SellOrderPrice?>,<?=$SellOrderAmount?>);"  style="cursor:pointer" 
					 class=" tooltip-x" rel="tooltip-x" data-placement="top" title="Buy <?=$SellOrderAmount?> <?=$first_curr?> at <?=$SellOrderPrice?> <?=$second_curr?>">
						<td style="text-align:right"><?=$SO['No']?><?=$SO['_id']['user_id']?></td>											
						<td style="text-align:right"><?=number_format(round($SO['_id']['PerPrice'],8),8)?></td>						
						<td style="text-align:right"><?=number_format(round($SO['Amount'],8),8)?></td>
						<td style="text-align:right"><?=number_format(round($SO['Amount']*$SO['_id']['PerPrice'],8),8)?></td>
					</tr>
					<?php }?>
				</tbody>
			</table>
		</div>
	</div>
	<div class="span4"  style="border:1px solid gray;">
		<div class="navbar">
			<div class="navbar-inner">
			<a class="brand" href="#"><?=$t('Orders:')?>
			 <small><?=$t('Buy')?> <?=$first_curr?> &lt; <?=$second_curr?></small></a>
<?php  foreach($TotalBuyOrders['result'] as $TBO){
	$BuyAmount = $TBO['Amount'];
	$BuyTotalAmount = $TBO['TotalAmount'];
}?>			
			</div>
		</div>
		<div id="BuyOrders" style="height:300px;overflow:auto;margin-top:-20px  ">			
			<table class="table table-condensed table-bordered table-hover"  style="font-size:12px ">
				<thead>
					<tr>
					<th style="text-align:center " rowspan="2">#</th>										
					<th style="text-align:center "><?=$t('Price')?></th>
					<th style="text-align:center "><?=$first_curr?></th>
					<th style="text-align:center "><?=$second_curr?></th>					
					</tr>
					<tr>
					<th style="text-align:center " ><?=$t('Total')?> &raquo;</th>
					<th style="text-align:right " ><?=number_format($BuyAmount,8)?></th>
					<th style="text-align:right " ><?=number_format($BuyTotalAmount,8)?></th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$BuyOrderAmount = 0;
					foreach($BuyOrders['result'] as $BO){
						$BuyOrderPrice = number_format(round($BO['_id']['PerPrice'],8),8);
						$BuyOrderAmount = number_format(round($BO['Amount'],8),8);
					
					?>
					<tr onClick="BuyOrderFill(<?=$BuyOrderPrice?>,<?=$BuyOrderAmount?>);" style="cursor:pointer" 
					 class=" tooltip-x" rel="tooltip-x" data-placement="top" title="Sell <?=$BuyOrderAmount?> <?=$first_curr?> at <?=$BuyOrderPrice?> <?=$second_curr?>">
						<td style="text-align:right"><?=$BO['No']?><?=$BO['_id']['username']?></td>											
						<td style="text-align:right"><?=number_format(round($BO['_id']['PerPrice'],8),8)?></td>
						<td style="text-align:right"><?=number_format(round($BO['Amount'],8),8)?></td>
						<td style="text-align:right"><?=number_format(round($BO['_id']['PerPrice']*$BO['Amount'],8),8)?></td>																	
					</tr>
					<?php }?>
				</tbody>
			</table>
		</div>	
	</div>
		<div class="span3"  style="height:334px;">
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
				<?php foreach($YourCompleteOrders as $YO){ ?>
					<tr style="cursor:pointer"
					class=" tooltip-x" rel="tooltip-x" data-placement="top" title="<?=$YO['Action']?> <?=number_format($YO['Amount'],3)?> at 
					<?=number_format($YO['PerPrice'],8)?> on <?=gmdate('Y-m-d H:i:s',$YO['DateTime']->sec)?>">
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
</div><br>
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
