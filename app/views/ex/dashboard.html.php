<?php
use lithium\util\String;
?>
<?php use lithium\core\Environment; 
if(Environment::get('locale')=="en_US"){$locale = "en";}else{$locale = Environment::get('locale');}
?>
<div style="background-image:url(/img/Stamp.png);background-position:bottom right;background-repeat:no-repeat">
<div class="row container" >
	<div class="span11">
		<div class="navbar">
			<div class="navbar-inner1">
			<a class="brand" href="#"><?=$t('Accounts')?> </a>
			<a href="/<?=$locale?>/users/funding_btc" class="btn btn-primary"><?=$t("Funding BTC")?></a>
			<a href="/<?=$locale?>/users/funding_ltc" class="btn btn-primary"><?=$t("Funding LTC")?></a>			
			<a href="/<?=$locale?>/users/funding_fiat" class="btn btn-primary"><?=$t("Funding Fiat")?></a>						
			<a href="/<?=$locale?>/okpay"><img src="/img/DepositOkPay.png" width="110px" style="margin-top:4px "></a>
			<a href="/<?=$locale?>/users/transactions" class="btn btn-primary"><?=$t("Transactions")?></a>			
			<a href="/<?=$locale?>/users/settings" class="btn btn-primary"><?=$t("Settings")?></a>									
			</div>
		</div>
		<table class="table table-condensed table-bordered table-hover" style="margin-top:-20px">
				<tr style="background-color:#CFFDB9">
					<td width="16%"><strong><?=$t("Verification Process")?></strong></td>
					<td width="16%" style="text-align:center ">
<!-- Email start-->					
					<?php 
					if($details['email.verified']=='Yes'){
					?><a href="#" class="label label-success tooltip-x" rel="tooltip-x" data-placement="top" title="Completed!"><i class="icon-ok icon-black"></i> <?=$t("Email")?></a><?php }else{
					?><a href="/users/email/" class="label label-warning tooltip-x" rel="tooltip-x" data-placement="top" title="Compulsary to transact!"><i class="icon-remove icon-black"></i> <?=$t("Email")?></a><?php }
					?>
<!-- Email end-->										
					</td>					
					<td width="16%" style="text-align:center ">
<!-----Bank Details start----->					
					<?php 
					if(strlen($details['bank.verified'])==0){
					?>
						<a href="/users/settings/bank" class="label label-warning tooltip-x" rel="tooltip-x" data-placement="top" title="Compulsary to transact!"><i class="icon-remove icon-black"></i> <?=$t("Withdrawal Address & Bank")?></a>
					<?php }elseif($details['bank.verified']=='No'){?>
						<a href="#" class="label label-important tooltip-x" rel="tooltip-x" data-placement="top" title="Pending verification!"><i class="icon-edit icon-black"></i> <?=$t("Withdrawal Address & Bank")?></a>
					<?php }else{ ?>
						<a href="#" class="label label-success tooltip-x" rel="tooltip-x" data-placement="top" title="Completed!"><i class="icon-ok icon-black"></i> <?=$t("Withdrawal Address & Bank")?></a>					
					<?php }	?>
<!-----Bank Details end----->					
					</td>
					<td width="16%" style="text-align:center ">
<!-----Utility Details start----->					
						<?php 
						if(strlen($details['utility.verified'])==0){
						?>	
							<a href="/users/settings/utility" class="label label-warning tooltip-x" rel="tooltip-x" data-placement="top" title="Compulsary to transact!"><i class="icon-remove icon-black"></i> <?=$t("Proof of Address")?></a>
						<?php }elseif($details['utility.verified']=='No'){?>
							<a href="#" class="label label-important tooltip-x" rel="tooltip-x" data-placement="top" title="Pending verification!"><i class="icon-edit icon-black"></i> <?=$t("Proof of Address")?></a>
						<?php }else{ ?>
							<a href="#" class="label label-success tooltip-x" rel="tooltip-x" data-placement="top" title="Completed!"><i class="icon-ok icon-black"></i> <?=$t("Proof of Address")?></a>					
						<?php }	?>
<!-----Utility Details end----->					
					</td>
					<td width="16%" style="text-align:center ">
<!-----Government Details start----->					
					<?php 
					if(strlen($details['government.verified'])==0){
					?>
						<a href="/users/settings/government" class="label label-warning tooltip-x" rel="tooltip-x" data-placement="top" title="Compulsary to transact!"><i class="icon-remove icon-black"></i> <?=$t("Government Photo ID")?></a>
					<?php }elseif($details['government.verified']=='No'){?>
						<a href="#" class="label label-important tooltip-x" rel="tooltip-x" data-placement="top" title="Pending verification!"><i class="icon-edit icon-black"></i> <?=$t("Government Photo ID")?></a>
					<?php }else{ ?>
						<a href="#" class="label label-success tooltip-x" rel="tooltip-x" data-placement="top" title="Completed!"><i class="icon-ok icon-black"></i> <?=$t("Government ID")?></a>					
					<?php }	?>
<!-----Government Details end----->					
					</td>
					<td width="16%" style="text-align:center ">
<!-- Mobile start-->										
					<?php 
					if($details['mobile.verified']=='Yes'){
					?><a href="#" class="label label-success tooltip-x" rel="tooltip-x" data-placement="top" title="Completed!"><i class="icon-ok icon-black"></i> <?=$t("Mobile/Phone")?></a><?php }else{
					?><a href="/users/mobile/" class="label label-warning tooltip-x" rel="tooltip-x" data-placement="top" title="Optional!"><i class="icon-remove icon-black"></i> <?=$t("Mobile/Phone")?></a><?php }
					?>
<!-- Mobile end-->															
					</td>
				</tr>
	</table>
		<table class="table table-condensed table-bordered table-hover" style="margin-top:-20px">
			<thead>
				<tr>
					<th><?=$t("Currency")?></th>
					<th style="text-align:center">BTC</th>
					<th style="text-align:center">LTC</th> 
					<th style="text-align:center">USD</th>
					<th style="text-align:center">EUR</th>
					<th style="text-align:center">GBP</th>
					<th style="text-align:center">CAD</th>					
				</tr>
			</thead>
			<tbody>
				<?php 

				foreach($YourOrders['Buy']['result'] as $YO){
					$Buy[$YO['_id']['FirstCurrency']] = $Buy[$YO['_id']['FirstCurrency']] + $YO['Amount'];
					$BuyWith[$YO['_id']['SecondCurrency']] = $BuyWith[$YO['_id']['SecondCurrency']] + $YO['TotalAmount'];					
				}					
				foreach($YourOrders['Sell']['result'] as $YO){
					$Sell[$YO['_id']['FirstCurrency']] = $Sell[$YO['_id']['FirstCurrency']] + $YO['Amount'];
					$SellWith[$YO['_id']['SecondCurrency']] = $SellWith[$YO['_id']['SecondCurrency']] + $YO['TotalAmount'];					
				}					
				foreach($YourCompleteOrders['Buy']['result'] as $YCO){
					$ComBuy[$YCO['_id']['FirstCurrency']] = $ComBuy[$YCO['_id']['FirstCurrency']] + $YCO['Amount'];
					$ComBuyWith[$YCO['_id']['SecondCurrency']] = $ComBuyWith[$YCO['_id']['SecondCurrency']] + $YCO['TotalAmount'];					
				}					
				foreach($YourCompleteOrders['Sell']['result'] as $YCO){
					$ComSell[$YCO['_id']['FirstCurrency']] = $ComSell[$YCO['_id']['FirstCurrency']] + $YCO['Amount'];
					$ComSellWith[$YCO['_id']['SecondCurrency']] = $ComSellWith[$YCO['_id']['SecondCurrency']] + $YCO['TotalAmount'];					
				}					
				foreach($Commissions['result'] as $C){
					switch ($C['_id']['CommissionCurrency']){
					    case "BTC":
					        $BTCComm = $C['Commission'];
				    	    break;
					    case "LTC":
					        $LTCComm = $C['Commission'];
				    	    break;
					    case "GBP":
					        $GBPComm = $C['Commission'];
				    	    break;
					    case "USD":
					        $USDComm = $C['Commission'];
				    	    break;
					    case "CAD":
					        $CADComm = $C['Commission'];
				    	    break;

					    case "EUR":
					        $EURComm = $C['Commission'];
				    	    break;
					}
				}
				foreach($CompletedCommissions['result'] as $C){
					switch ($C['_id']['CommissionCurrency']){
					    case "BTC":
					        $CompletedBTCComm = $C['Commission'];
				    	    break;
					    case "LTC":
					        $CompletedLTCComm = $C['Commission'];
				    	    break;
					    case "GBP":
					        $CompletedGBPComm = $C['Commission'];
				    	    break;
					    case "USD":
					        $CompletedUSDComm = $C['Commission'];
				    	    break;
					    case "CAD":
					        $CompletedCADComm = $C['Commission'];
				    	    break;
					    case "EUR":
					        $CompletedEURComm = $C['Commission'];
				    	    break;
					}
				}
				?>
				<tr>
					<td><strong><?=$t('Opening Balance')?></strong></td>
					<td style="text-align:right "><?=number_format($details['balance.BTC']+$Sell['BTC'],8)?></td>
					<td style="text-align:right "><?=number_format($details['balance.LTC']+$Sell['LTC'],8)?></td> 
					<td style="text-align:right "><?=number_format($details['balance.USD']+$BuyWith['USD'],4)?></td>					
					<td style="text-align:right "><?=number_format($details['balance.EUR']-$BuyWith['EUR'],4)?></td>										
					<td style="text-align:right "><?=number_format($details['balance.GBP']-$BuyWith['GBP'],4)?></td>										
					<td style="text-align:right "><?=number_format($details['balance.CAD']-$BuyWith['CAD'],4)?></td>															
				</tr>
				<tr>
					<td><strong><?=$t('Current Balance')?></strong><br>
					<?=$t("(including pending orders)")?></td>
					<td style="text-align:right "><?=number_format($details['balance.BTC'],8)?></td>
					<td style="text-align:right "><?=number_format($details['balance.LTC'],8)?></td> 
					<td style="text-align:right "><?=number_format($details['balance.USD'],4)?></td>
					<td style="text-align:right "><?=number_format($details['balance.EUR'],4)?></td>
					<td style="text-align:right "><?=number_format($details['balance.GBP'],4)?></td>
					<td style="text-align:right "><?=number_format($details['balance.CAD'],4)?></td>					
				</tr>
				<tr>
					<td><strong><?=$t('Pending Buy Orders')?></strong></td>
					<td style="text-align:right ">+<?=number_format($Buy['BTC'],8)?></td>
 					<td style="text-align:right ">+<?=number_format($Buy['LTC'],8)?></td>					
					<td style="text-align:right ">-<?=number_format($BuyWith['USD'],4)?></td>										
					<td style="text-align:right ">-<?=number_format($BuyWith['EUR'],4)?></td>										
					<td style="text-align:right ">-<?=number_format($BuyWith['GBP'],4)?></td>										
					<td style="text-align:right ">-<?=number_format($BuyWith['CAD'],4)?></td>															
				</tr>
				<tr>
					<td><strong><?=$t('Pending Sell Orders')?></strong></td>
					<td style="text-align:right ">-<?=number_format($Sell['BTC'],8)?></td>
					<td style="text-align:right ">-<?=number_format($Sell['LTC'],8)?></td>					
					<td style="text-align:right ">+<?=number_format($SellWith['USD'],4)?></td>										
					<td style="text-align:right ">+<?=number_format($SellWith['EUR'],4)?></td>										
					<td style="text-align:right ">+<?=number_format($SellWith['GBP'],4)?></td>										
					<td style="text-align:right ">+<?=number_format($SellWith['CAD'],4)?></td>															
				</tr>
				<tr>
					<td  style="border-top:1px solid black"><strong><?=$t('After Execution')?></strong></td>
					<td style="text-align:right;border-top:1px solid black "><?=number_format($details['balance.BTC']+$Buy['BTC']-$BTCComm,8)?></td>
					<td style="text-align:right;border-top:1px solid black "><?=number_format($details['balance.LTC']+$Buy['LTC']-$LTCComm,8)?></td> 
					<td style="text-align:right;border-top:1px solid black "><?=number_format($details['balance.USD']+$SellWith['USD']-$USDComm,4)?></td>					
					<td style="text-align:right;border-top:1px solid black "><?=number_format($details['balance.EUR']+$SellWith['EUR']-$EURComm,4)?></td>										
					<td style="text-align:right;border-top:1px solid black "><?=number_format($details['balance.GBP']+$SellWith['GBP']-$GBPComm,4)?></td>										
					<td style="text-align:right;border-top:1px solid black "><?=number_format($details['balance.CAD']+$SellWith['CAD']-$CADComm,4)?></td>															
				</tr>
				<tr>
					<td style="border-bottom:double black;"><strong><?=$t('Commissions')?></strong></td>
					<td style="text-align:right;border-bottom:double black;"><?=number_format($BTCComm,8)?></td>
 					<td style="text-align:right;border-bottom:double black; "><?=number_format($LTCComm,8)?></td> 
					<td style="text-align:right;border-bottom:double black; "><?=number_format($USDComm,4)?></td>
					<td style="text-align:right;border-bottom:double black; "><?=number_format($EURComm,4)?></td>
					<td style="text-align:right;border-bottom:double black; "><?=number_format($GBPComm,4)?></td>
					<td style="text-align:right;border-bottom:double black; "><?=number_format($CADComm,4)?></td>					
				</tr>
		</table>
		</div>
	</div>
	<div class="row container" >
	<div class="span11">
		<div class="navbar">
			<div class="navbar-inner3">
			<a class="brand" href="#"><?=$t('Summary')?> </a>			
			</div>
		</div>
		<table class="table table-condensed table-bordered table-hover" style="margin-top:-20px">
			<thead>
				<tr>
					<th><?=$t("Currency")?></th>
					<th style="text-align:center">BTC</th>
					<th style="text-align:center">LTC</th> 
					<th style="text-align:center">USD</th>
					<th style="text-align:center">EUR</th>
					<th style="text-align:center">GBP</th>
					<th style="text-align:center">CAD</th>					
				</tr>
			</thead>
			<tbody>

				<tr>
					<td><strong><?=$t('Complete Buy Orders')?></strong></td>
					<td style="text-align:right "><?=number_format($ComBuy['BTC'],8)?></td>
					<td style="text-align:right "><?=number_format($ComBuy['LTC'],8)?></td>				
					<td style="text-align:right "><?=number_format($ComBuyWith['USD'],4)?></td>										
					<td style="text-align:right "><?=number_format($ComBuyWith['EUR'],4)?></td>										
					<td style="text-align:right "><?=number_format($ComBuyWith['GBP'],4)?></td>										
					<td style="text-align:right "><?=number_format($ComBuyWith['CAD'],4)?></td>															
				</tr>
				<tr>
					<td><strong><?=$t('Complete Sell Orders')?></strong></td>
					<td style="text-align:right "><?=number_format($ComSell['BTC'],8)?></td>
					<td style="text-align:right "><?=number_format($ComSell['LTC'],8)?></td>		
					<td style="text-align:right "><?=number_format($ComSellWith['USD'],4)?></td>										
					<td style="text-align:right "><?=number_format($ComSellWith['EUR'],4)?></td>										
					<td style="text-align:right "><?=number_format($ComSellWith['GBP'],4)?></td>										
					<td style="text-align:right "><?=number_format($ComSellWith['CAD'],4)?></td>															
				</tr>
				<tr>
					<td><strong><?=$t('Completed Order Commissions')?></strong></td>
					<td style="text-align:right "><?=number_format($CompletedBTCComm,8)?></td>
					<td style="text-align:right "><?=number_format($CompletedLTCComm,8)?></td> 
					<td style="text-align:right "><?=number_format($CompletedUSDComm,4)?></td>
					<td style="text-align:right "><?=number_format($CompletedEURComm,4)?></td>
					<td style="text-align:right "><?=number_format($CompletedGBPComm,4)?></td>
					<td style="text-align:right "><?=number_format($CompletedCADComm,4)?></td>					
				</tr>


<!--
				<tr>
					<td><strong><?=$t('Convert to:')?></strong>
						<select name="Currency" class="span1" id="Currency">
							<option value="BTC">BTC</option>
							<option value="LTC">LTC</option>							
							<option value="USD">USD</option>							
							<option value="GBP">GBP</option>							
							<option value="EUR">EUR</option>							
						</select>
					</td>
					<td  style="text-align:right"><input type="text" value="1.000" id="BTCRate" class="span1"></td>
					<td  style="text-align:right"><input type="text" value="0.025" id="LTCRate" class="span1"></td>					
					<td  style="text-align:right"><input type="text" value="96.000" id="USDRate" class="span1"></td>					
					<td  style="text-align:right"><input type="text" value="80.000" id="GBPRate" class="span1"></td>					
					<td  style="text-align:right"><input type="text" value="75.000" id="EURRate" class="span1"></td>					
					<td><a href="#" onClick="ConvertBalance();" class="btn btn-primary">Convert</a></td>
				</tr>
				<tr>
					<td><strong><?=$t('Opening Balance')?> <span id="SelectedCurrency"></span></strong></td>
					<td style="text-align:right" id="ConvBTC"></td>
					<td style="text-align:right" id="ConvLTC"></td>
					<td style="text-align:right" id="ConvUSD"></td>
					<td style="text-align:right" id="ConvGBP"></td>
					<td style="text-align:right" id="ConvEUR"></td>															
				</tr>
-->
			</tbody>				
		</table>
	</div>
</div>
<div class="row container" >
<!--------
	<div class="span5">
		<div class="navbar">
			<div class="navbar-inner">
			<a class="brand" href="#"><?=$t('Users you transacted with (max 20)')?> </a>
			</div>
		</div>
		<table class="table table-condensed table-bordered table-hover" style="margin-top:-20px">
			<thead>
				<tr>
					<th style="text-align:center"><?=$t('User name')?></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td >
			<?php foreach($RequestFriends['result'] as $RF){
			$friend = array();
			if($details['Friend']!=""){
				foreach($details['Friend'] as $f){
					array_push($friend, $f);
				}
			}
			if(!in_array($RF['_id']['TransactUsername'],$friend,TRUE)){
			  ?><a href="/<?=$locale?>/ex/AddFriend/<?=String::hash($RF['_id']['TransactUser_id'])?>/<?=$RF['_id']['TransactUser_id']?>/<?=$RF['_id']['TransactUsername']?>"
				class=" tooltip-x label label-success" rel="tooltip-x" data-placement="top" title="Add to receive alerts from <?=$RF['_id']['TransactUsername']?>"
				style="font-weight:bold "><i class="icon-plus"></i> <?=$RF['_id']['TransactUsername']?></a>
			<?php }else{?>
			<a  href="/<?=$locale?>/ex/RemoveFriend/<?=String::hash($RF['_id']['TransactUser_id'])?>/<?=$RF['_id']['TransactUser_id']?>/<?=$RF['_id']['TransactUsername']?>" class="tooltip-x label label-warning" rel="tooltip-x" data-placement="top" title="Already a friend <?=$RF['_id']['TransactUsername']?>, Remove!">
<i class="icon-minus"></i>			<?=$RF['_id']['TransactUsername']?></a>
			<?php }?>
			<?php }?>
					</td>
				</tr>			
			</tbody>
		</table>
	</div>
-->	
	<div class="span5">
		<div class="navbar">
			<div class="navbar-inner2">
			<a class="brand" href="#">Pending Orders</a>
			</div>
		</div>
		<table class="table table-condensed table-bordered table-hover" style="margin-top:-20px">
				<tr>
					<th><?=$t("Status")?></th>
					<th><?=$t("BTC")?></th>
					<th><?=$t("Amount")?></th>					
					<th><?=$t("Avg Price")?></th>										
				</tr>
				<tr>
					<th colspan="4"><?=$t("Pending orders")?></th>
				</tr>
				<?php foreach ($TotalOrders['Buy']['result'] as $r){ ?>
					<tr>
						<td><?=$r['_id']['Action']?> <?=$r['_id']['FirstCurrency']?> with <?=$r['_id']['SecondCurrency']?></td>
						<td style="text-align:right "><?=number_format($r['Amount'],8)?></td>
						<td style="text-align:right "><?=number_format($r['TotalAmount'],8)?></td>						
						<td style="text-align:right "><?=number_format($r['TotalAmount']/$r['Amount'],8)?></td>												
					</tr>
				<?php }?>
				<?php foreach ($TotalOrders['Sell']['result'] as $r){ ?>
					<tr>
						<td><?=$r['_id']['Action']?> <?=$r['_id']['FirstCurrency']?> with <?=$r['_id']['SecondCurrency']?></td>
						<td style="text-align:right "><?=number_format($r['Amount'],8)?></td>
						<td style="text-align:right "><?=number_format($r['TotalAmount'],8)?></td>						
						<td style="text-align:right "><?=number_format($r['TotalAmount']/$r['Amount'],8)?></td>																		
					</tr>
				<?php }?>
		</table>
	</div>

	<div class="span5">
		<div class="navbar">
			<div class="navbar-inner1">
			<a class="brand" href="#">Completed Orders</a>
			</div>
		</div>
		<table class="table table-condensed table-bordered table-hover" style="margin-top:-20px">
				<tr>
					<th><?=$t("Status")?></th>
					<th><?=$t("BTC")?></th>
					<th><?=$t("Amount")?></th>					
					<th><?=$t("Avg Price")?></th>										
				</tr>
					<th colspan="4"><?=$t("Completed orders")?></th>
				</tr>
				<?php foreach ($TotalCompleteOrders['Buy']['result'] as $r){ ?>
					<tr>
						<th><?=$r['_id']['Action']?> <?=$r['_id']['FirstCurrency']?> with <?=$r['_id']['SecondCurrency']?></th>
						<th style="text-align:right "><?=number_format($r['Amount'],8)?></th>
						<th style="text-align:right "><?=number_format($r['TotalAmount'],8)?></th>						
						<td style="text-align:right "><?=number_format($r['TotalAmount']/$r['Amount'],8)?></td>																		
					</tr>
				<?php }?>
				<?php foreach ($TotalCompleteOrders['Sell']['result'] as $r){ ?>
					<tr>
						<th><?=$r['_id']['Action']?> <?=$r['_id']['FirstCurrency']?> with <?=$r['_id']['SecondCurrency']?></th>
						<th style="text-align:right "><?=number_format($r['Amount'],8)?></th>
						<th style="text-align:right "><?=number_format($r['TotalAmount'],8)?></th>						
						<td style="text-align:right "><?=number_format($r['TotalAmount']/$r['Amount'],8)?></td>																		
					</tr>
				<?php }?>
		</table>
		</div>
	</div>
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
	<small><?=$t('Users')?>: <?=$UsersRegistered?> / <?=$t('Online')?>: <?=$OnlineUsers?></small>
</div>	
</div>