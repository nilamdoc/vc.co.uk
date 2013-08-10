<div class="row" >
	<div class="span11">
		<div class="navbar">
			<div class="navbar-inner">
			<a class="brand" href="#"><?=$t('Accounts')?> </a>
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
					<th><?=$t('Action')?></th>					
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
					    case "EUR":
					        $EURComm = $C['Commission'];
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
					<td></td>										
				</tr>
				<tr>
					<td><strong><?=$t('Current Balance')?></strong><br>
					(including pending orders)</td>
					<td style="text-align:right "><?=number_format($details['balance.BTC'],8)?></td>
					<td style="text-align:right "><?=number_format($details['balance.LTC'],8)?></td>
					<td style="text-align:right "><?=number_format($details['balance.USD'],4)?></td>
					<td style="text-align:right "><?=number_format($details['balance.EUR'],4)?></td>
					<td style="text-align:right "><?=number_format($details['balance.GBP'],4)?></td>
					<td><a href="" class="btn btn-primary">Funding</a></td>																									
				</tr>
				<tr>
					<td><strong><?=$t('Pending Buy Orders')?></strong></td>
					<td style="text-align:right ">+<?=number_format($Buy['BTC'],8)?></td>
					<td style="text-align:right ">+<?=number_format($Buy['LTC'],8)?></td>					
					<td style="text-align:right ">-<?=number_format($BuyWith['USD'],4)?></td>										
					<td style="text-align:right ">-<?=number_format($BuyWith['EUR'],4)?></td>										
					<td style="text-align:right ">-<?=number_format($BuyWith['GBP'],4)?></td>										
					<td></td>					
				</tr>
				<tr>
					<td><strong><?=$t('Pending Sell Orders')?></strong></td>
					<td style="text-align:right ">-<?=number_format($Sell['BTC'],8)?></td>
					<td style="text-align:right ">-<?=number_format($Sell['LTC'],8)?></td>					
					<td style="text-align:right ">+<?=number_format($SellWith['USD'],4)?></td>										
					<td style="text-align:right ">+<?=number_format($SellWith['EUR'],4)?></td>										
					<td style="text-align:right ">+<?=number_format($SellWith['GBP'],4)?></td>										
					<td></td>					
				</tr>
				<tr>
					<td><strong><?=$t('After Execution')?></strong></td>
					<td style="text-align:right "><?=number_format($details['balance.BTC']+$Buy['BTC']-$BTCComm,8)?></td>
					<td style="text-align:right "><?=number_format($details['balance.LTC']+$Buy['LTC']-$LTCComm,8)?></td>
					<td style="text-align:right "><?=number_format($details['balance.USD']+$SellWith['USD']-$USDComm,4)?></td>					
					<td style="text-align:right "><?=number_format($details['balance.EUR']+$SellWith['EUR']-$EURComm,4)?></td>										
					<td style="text-align:right "><?=number_format($details['balance.GBP']+$SellWith['GBP']-$GBPComm,4)?></td>										
					<td></td>										
				</tr>
				<tr>
					<td><strong><?=$t('Commissions')?></strong></td>
					<td style="text-align:right "><?=number_format($BTCComm,8)?></td>
					<td style="text-align:right "><?=number_format($LTCComm,8)?></td>
					<td style="text-align:right "><?=number_format($USDComm,4)?></td>
					<td style="text-align:right "><?=number_format($EURComm,4)?></td>
					<td style="text-align:right "><?=number_format($GBPComm,4)?></td>
					<td></td>										
				</tr>
				<tr>
					<td><strong><?=$t('Complete Buy Orders')?></strong></td>
					<td style="text-align:right "><?=number_format($ComBuy['BTC'],8)?></td>
					<td style="text-align:right "><?=number_format($ComBuy['LTC'],8)?></td>					
					<td style="text-align:right "><?=number_format($ComBuyWith['USD'],4)?></td>										
					<td style="text-align:right "><?=number_format($ComBuyWith['EUR'],4)?></td>										
					<td style="text-align:right "><?=number_format($ComBuyWith['GBP'],4)?></td>										
					<td></td>					
				</tr>
				<tr>
					<td><strong><?=$t('Complete Sell Orders')?></strong></td>
					<td style="text-align:right "><?=number_format($ComSell['BTC'],8)?></td>
					<td style="text-align:right "><?=number_format($ComSell['LTC'],8)?></td>					
					<td style="text-align:right "><?=number_format($ComSellWith['USD'],4)?></td>										
					<td style="text-align:right "><?=number_format($ComSellWith['EUR'],4)?></td>										
					<td style="text-align:right "><?=number_format($ComSellWith['GBP'],4)?></td>										
					<td></td>					
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
<div class="row" >
	<div class="span5">
		<div class="navbar">
			<div class="navbar-inner">
			<a class="brand" href="#"><?=$t('Users you transacted with')?> </a>
			</div>
		</div>
		<table class="table table-condensed table-bordered table-hover" style="margin-top:-20px">
			<thead>
				<tr>
					<th style="text-align:center"><?=$t('User name')?></th>
					<th style="text-align:center"><?=$t('Action')?></th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($RequestFriends['result'] as $RF){?>
				<tr>
					<td><?=$RF['_id']['TransactUsername']?></td>
					<td><a href="">Add as a friend</a></td>
				</tr>
			<?php }?>
			</tbody>
		</table>
	</div>
	<div class="span6">
		<div class="navbar">
			<div class="navbar-inner">
			<a class="brand" href="#"><?=$t('Accepted Friends')?> </a>
			</div>
		</div>
		<table class="table table-condensed table-bordered table-hover" style="margin-top:-20px">
			<thead>
				<tr>
					<th style="text-align:center"><?=$t('Date accepted')?></th>
					<th style="text-align:center"><?=$t('User name')?></th>
					<th style="text-align:center"><?=$t('Action')?></th>
					<th style="text-align:center"><?=$t('Profile')?></th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
</div>	
