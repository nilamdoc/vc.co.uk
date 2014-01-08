<style>
.Address_success{background-color: #9FFF9F;font-weight:bold}
</style>
<h4>Funding - GBP / USD / EUR</h4>
<h2 class="alert alert-error">Please ensure you send funds securely with appropriate Royal Mail cover.</h2>
<div class="accordion" id="accordion2">
	<div class="accordion-group">
		<div class="accordion-heading">
			<?php 
				if($details['bank']['verified']=="Yes" && $details['utility']['verified']=="Yes" && $details['government']['verified']=="Yes" ){?>
			<span class="accordion-toggle btn" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">				
				<strong><?=$t('USD / GBP / EUR Deposits / Withdrawals')?></strong> 
			</span>
			<?php }else{?>
			<span class="accordion-toggle btn" data-toggle="collapse" data-parent="#accordion2" href="#collapseVerify">							
				<strong>Verification incomplete!</strong>
			</span>	
			<?php }?>
		</div>
		<div id="collapseVerify" class="accordion-body ">
			<div class="accordion-inner">
				<div class="navbar">
					<div class="navbar-inner3">
						<a class="brand" href="#"><?=$t('Complete Verification')?> </a>
					</div>				
				<div class="well">
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
<!-----Utility Details start----->					
					<?php 
					if(strlen($details['utility.verified'])==0){
					?>
						<a href="/users/settings/utility" class="label label-warning tooltip-x" rel="tooltip-x" data-placement="top" title="Compulsary to transact!"><i class="icon-remove icon-black"></i> <?=$t("Proof of Address")?></a>
					<?php }elseif($details['utility.verified']=='No'){?>
						<a href="#" class="label label-important tooltip-x" rel="tooltip-x" data-placement="top" title="Pending verification!"><i class="icon-edit icon-black"></i> <?=$t("Utility Bill")?></a>
					<?php }else{ ?>
						<a href="#" class="label label-success tooltip-x" rel="tooltip-x" data-placement="top" title="Completed!"><i class="icon-ok icon-black"></i> <?=$t("Utility Bill")?></a>					
					<?php }	?>
<!-----Utility Details end----->					

					</div>
				</div>
			</div>
		</div>

		<div id="collapseTwo" class="accordion-body ">
			<div class="accordion-inner">
				<div class="row">
					<div class="span5">
						<div class="navbar">
							<form action="/users/deposit/" method="post" class="form">
							<div class="navbar-inner1">
							<a class="brand" href="#"><?=$t('Deposit USD / GBP / EUR')?> </a>
							</div>
							<table class="table table-condensed table-bordered table-hover" style="margin-top:-20px">
								<tr style="background-color:#CFFDB9">
									<td colspan="2"><?=$t("Send payment to")?></td>
								</tr>
								<tr>
									<td>Registered Address: </td>
									<td>IBWT JD Ltd<br>
										 31 North Down Crescent<br>
										 Keyham, Plymouth<br>
										 Devon, PL2 2AR<br>
										United Kingdom</td>
								</tr>
								<tr  class=" tooltip-x" rel="tooltip-x" data-placement="top" title="Quote this reference number in your deposit">
									<td>Reference:</td>
									<?php $Reference = substr($details['username'],0,10).rand(10000,99999);?>
									<td><?=$Reference?></td>
								</tr>
								<tr  class=" tooltip-x" rel="tooltip-x" data-placement="top" title="Amount should be between 1 and 10000">
									<td>Amount:</td>
									<td><input type="text" value="" class="span2" placeholder="1.0" min="1" max="10000" name="AmountFiat" id="AmountFiat" maxlength="5"></td>
								</tr>
								<tr  class=" tooltip-x" rel="tooltip-x" data-placement="top" title="Select a currency">
									<td>Currency:</td>
									<td><select name="Currency" id="Currency" class="span2">
											<option value="GBP">GBP</option>
											<option value="USD">USD</option>							
											<option value="EUR">EUR</option>							
									</select></td>
								</tr>
								<tr>
									<td colspan="2">
									<p><strong><a href="/company/funding" target="_blank">Please make SURE you check with Royal Mail compensation cover and how to deposit BEFORE sending any funds!</a> </strong></p>
									</td>
								</tr>
								<tr  class=" tooltip-x" rel="tooltip-x" data-placement="top" title="Once verified and processed your funds will be mailed.">
									<td colspan="2" style="text-align:center ">
									<input type="hidden" name="Reference" id="Reference" value="<?=$Reference?>">
										<input type="submit" value="Send email to admin for approval" class="btn btn-primary" onclick="return CheckDeposit();">
									</td>
								</tr>
							</table>
						</form>
					</div>
					</div>
					<div class="span6">
						<div class="navbar">
							<form action="/users/withdraw/" method="post" class="form">		
							<div class="navbar-inner2">
							<a class="brand" href="#"><?=$t('Withdraw USD / GBP / EUR')?> </a>
							</div>
							<table class="table table-condensed table-bordered table-hover" style="margin-top:-20px">
								<tr style="background-color:#CFFDB9">
									<td><?=$t("Balance")?></td>
									<td style="text-align:right "><?=$details['balance.USD']?> USD</td>					
									<td style="text-align:right "><?=$details['balance.GBP']?> GBP</td>
									<td style="text-align:right "><?=$details['balance.EUR']?> EUR</td>					
								</tr>			
								<tr style="background-color: #FDDBAC">
								<?php 
								$AmountGBP = 0;$AmountUSD = 0;$AmountEUR = 0;
								foreach($transactions as $transaction){
									if($transaction['Currency']=='GBP'){
										$AmountGBP = $AmountGBP + $transaction['Amount'];
									}
									if($transaction['Currency']=='EUR'){
										$AmountEUR = $AmountEUR + $transaction['Amount'];
									}					
									if($transaction['Currency']=='USD'){
										$AmountUSD = $AmountUSD + $transaction['Amount'];
									}					
								}
								?>
									<td><?=$t("Withdrawal")?></td>
									<td style="text-align:right "><?=$AmountUSD?> USD</td>					
									<td style="text-align:right "><?=$AmountGBP?> GBP</td>
									<td style="text-align:right "><?=$AmountEUR?> EUR</td>					
								</tr>			
								<tr style="background-color:#CFFDB9">
									<td><?=$t("Net Balance")?></td>
									<td style="text-align:right "><?=$details['balance.USD']-$AmountUSD?> USD</td>					
									<td style="text-align:right "><?=$details['balance.GBP']-$AmountGBP?> GBP</td>
									<td style="text-align:right "><?=$details['balance.EUR']-$AmountEUR?> EUR</td>					
								</tr>							
								<tr>
									<td colspan="2">Withdrawal Methods:</td>
									<td colspan="2">
										<select name="WithdrawalMethod" id="WithdrawalMethod" onChange="PaymentMethod(this.value);">
											<option value="post">Postal Address - Royal Mail</option>
											<option value="bank">Bank</option>
										</select>
									</td>
								</tr>

								<tr>
								<td colspan="4">
									<div id="WithdrawalBank" style="display:none">
								<table class="table table-condensed table-bordered table-hover">								
									<tr>
										<td>Account name:</td>
										<td><input type="text" name="AccountName" id="AccountName" placeholder="Verified bank account name" value="<?=$details['bank.bankname']?>"></td>
									</tr>
									<tr>
										<td>Sort code: </td>
										<td><input type="text" name="SortCode" id="SortCode" placeholder="01-01-10" value="<?=$details['bank.sortcode']?>"></td>
									</tr>
									<tr>
										<td>Account number:</td>
										<td><input type="text" name="AccountNumber" id="AccountNumber" placeholder="12345678" value="<?=$details['bank.accountnumber']?>"></td>
									</tr>
									</table>
									</div>
									<div id="WithdrawalPost"  style="display:block">
									<table class="table table-condensed table-bordered table-hover">
									<tr>
										<td>Name:</td>
										<td><input type="text" name="PostalName" id="PostalName" placeholder="Name" value="<?=$details['postal.Name']?>"></td>
									</tr>
									<tr>
										<td>Address:</td>
										<td><input type="text" name="PostalAddress" id="PostalAddress" placeholder="Name" value="<?=$details['postal.Address']?>"></td>
									</tr>
									<tr>
										<td>Street:</td>
										<td><input type="text" name="PostalStreet" id="PostalStreet" placeholder="Street" value="<?=$details['postal.Street']?>"></td>
									</tr>
									<tr>
										<td>City:</td>
										<td><input type="text" name="PostalCity" id="PostalCity" placeholder="City" value="<?=$details['postal.City']?>"></td>
									</tr>
									<tr>
										<td>Postal / Zip code:</td>
										<td><input type="text" name="PostalZip" id="PostalZip" placeholder="Zip" value="<?=$details['postal.Zip']?>"></td>
									</tr>
									<tr>
										<td>Country:</td>
										<td><input type="text" name="PostalCountry" id="PostalCountry" placeholder="Country" value="<?=$details['postal.Country']?>"></td>
									</tr>
									
									</table>
									</div>
							</td>
								<tr  class=" tooltip-x" rel="tooltip-x" data-placement="top" title="Quote this reference number in your withdrawal">
									<td colspan="2">Reference:</td>
									<?php $Reference = substr($details['username'],0,10).rand(10000,99999);?>
									<td colspan="2"><?=$Reference?></td>
								</tr>
								<tr  class=" tooltip-x" rel="tooltip-x" data-placement="top" title="Amount should be between 6 and 10000">
									<td colspan="2">Amount:</td>
									<td colspan="2"><input type="text" value="" class="span2" placeholder="5.0" min="5" max="10000" name="WithdrawAmountFiat" id="WithdrawAmountFiat" maxlength="5"><br>
				<small style="color:red ">
				&pound;1 mail withdrawal fee + royal mail fee (see below).<br>
&pound;2 bank withdrawal fee.<br>
Withdrawals must be in denominations of &pound;5.</small></td>
								</tr>
								<tr  class=" tooltip-x" rel="tooltip-x" data-placement="top" title="Select a currency">
									<td colspan="2">Currency:</td>
									<td colspan="2"><select name="WithdrawCurrency" id="WithdrawCurrency" class="span2">
											<option value="GBP">GBP</option>
											<option value="USD">USD</option>							
											<option value="EUR">EUR</option>							
									</select></td>
								</tr>
								<tr>
									<td colspan="2">Withdrawal Charges </td>
									<td colspan="2">
									<input type="radio" name="WithdrawalCharges" value="PriceFinder" id="WithdrawalCharges">
								<strong>1st Class</strong> <a href="http://www.royalmail.com/price-finder" target="_blank">Price Finder</a><br>
									&pound;50 = &pound;1.70<br>
									&pound;500 = &pound;6.22<br>
									&pound;1,000 = &pound;19.84<br>
									&pound;2,500 = &pound;23.34<br>
										<input type="radio" name="WithdrawalCharges" value="PostalOrder" id="WithdrawalCharges">
									<a href="http://www.postoffice.co.uk/postal-orders" target="_blank">Postal Order</a><br>
									&pound;0.50 - &pound;4.99 = 50p<br>
									&pound;5 - &pound;9.99 = &pound;1.00<br>
									&pound;10.00 - &pound;99.99 = 12.50%<br>
									&pound;100 - &pound;250 = 12.50%<br>
									</td>
								</tr>
								<tr>
									<td colspan="4"><p><strong>Make SURE you choose the appropriate Royal Mail charge to cover the amount you are withdrawing and that your IBWT account contains enough to cover the charge. Otherwise your withdrawal will be declined by IBWT.</strong></p></td>
								</tr>
								<tr  class=" tooltip-x" rel="tooltip-x" data-placement="top" title="Once your email is approved, you will receive the funds in your bank account">
									<td colspan="4" style="text-align:center ">
									<input type="hidden" name="WithdrawReference" id="WithdrawReference" value="<?=$Reference?>">
										<input type="submit" value="Send email to admin for approval" class="btn btn-primary" onclick="return CheckWithdrawal();">
									</td>
								</tr>
							</table>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>