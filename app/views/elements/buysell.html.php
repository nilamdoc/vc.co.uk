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
<div class="row" >
	<div class="span4">
		<div class="navbar">
			<div class="navbar-inner">
			<a class="brand" href="#"><?=$t('Buy')?> <?=$first_curr?> with <?=$second_curr?></a>
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
					<span class="label label-info"><span id="BalanceSecond"><?=$BalanceSecond?></span> <?=$second_curr?></span>
				</td>
				<td><?=$t('Lowest Ask Price')?><br>
					<span class="label label-warning"><span id="LowestAskPrice">0</span> <?=$second_curr?></span>
				</td>
			</tr>
			<tr>
				<td>
				<?=$this->form->field('BuyAmount', array('label'=>'Amount '.$first_curr,'class'=>'span1', 'value'=>0, 'onBlur'=>'$("#BuySubmitButton").attr("disabled", "disabled");')); ?>				
				</td>
				<td>
				<div class="input-append">
					<label for="BuyPriceper">Price per <?=$first_curr?></label>
					<input class="span1" id="BuyPriceper" name="BuyPriceper" type="text" onBlur='$("#BuySubmitButton").attr("disabled", "disabled");'>
					<span class="add-on"> <?=$second_curr?></span>
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
				<td><input type="submit" id="BuySubmitButton" class="btn btn-primary" disabled="disabled" value="Submit"></td>
			</tr>
		</table>
		<?=$this->form->end(); ?>
	</div>
	<div class="span4">
		<div class="navbar">
			<div class="navbar-inner">
			<a class="brand" href="#"><?=$t('Sell')?> <?=$first_curr?> get <?=$second_curr?></a>
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
			<span class="label label-info"><span id="BalanceFirst"><?=$BalanceFirst?></span> <?=$first_curr?></span>
			</td>
			<td><?=$t('Highest Bid Price')?><br>
				<span class="label label-success"><span id="HighestBidPrice">0</span> <?=$second_curr?></span>
			</td>
			</tr>
			<tr>
				<td>
				<?=$this->form->field('SellAmount', array('label'=>'Amount '.$first_curr,'class'=>'span1', 'value'=>0, 'onBlur'=>'$("#SellSubmitButton").attr("disabled", "disabled");')); ?>				
				</td>
				<td>
				<div class="input-append">
					<label for="SellPriceper">Price per <?=$first_curr?></label>
					<input class="span1" id="SellPriceper" name="SellPriceper" type="text"  onBlur='$("#SellSubmitButton").attr("disabled", "disabled");'>
					<span class="add-on"> <?=$second_curr?></span>
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
				<td><input type="submit" id="SellSubmitButton" class="btn btn-primary" disabled="disabled" value="Submit"></td>
			</tr>
		</table>
		<?=$this->form->end(); ?>		
	</div>
	<div class="span3"  style="height:314px;">
		<div class="navbar">
			<div class="navbar-inner">
			<a class="brand" href="#"><?=$t('Pending orders')?></a>
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
						<a href="/<?=$locale?>/ex/RemoveOrder/<?=String::hash($YO['_id'])?>/<?=$YO['_id']?>/<?=$sel_curr?>" title="Remove this order">
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
<?php  foreach($TotalSellOrders['result'] as $TSO){
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
						$SellOrderAmount = $SellOrderAmount + number_format(round($SO['Amount'],8),8);
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
						$BuyOrderAmount = $BuyOrderAmount + number_format(round($BO['Amount'],8),8);
					
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

</div>
