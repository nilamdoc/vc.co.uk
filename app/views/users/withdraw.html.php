<h4>Withdraw</h4>

<h5>Hi <?=$user['firstname']?>,</h5>

<p>You have requested to withdraw money from <?=COMPANY_URL?>.</p>
<p><strong>Thank you, your request has been sent for clearance.</strong></p>
<?php 

	if($data['WithdrawalMethod']=='okpay'){
?>
<strong>Withdrawal Method: OKPAY send to <?=$data['okpayEmail']?>.</strong>
<?php }?><table>
<?php 
	if($data['WithdrawalMethod']=='bank'){
?>
		<tr>
			<td>Account name:</td>
			<td><?=$data['AccountName']?></td>
		</tr>
		<tr>
			<td>Full Name:</td>
			<td><?=$user['firstname']?> <?=$user['lastname']?></td>
		</tr>
		<tr>
			<td>Sort code: </td>
			<td><?=$data['SortCode']?></td>	
		</tr>
		<tr>
			<td>Account number:</td>
			<td><?=$data['AccountNumber']?></td>
		</tr>
		<tr>
			<td>Withdrawal Charges:</td>
			<td>&pound; 2</td>
		</tr>
<?php }?>
<?php 
	if($data['WithdrawalMethod']=='post'){
?>
		<tr>
			<td>Withdrawal Method:</td>
			<td><?=$data['WithdrawalMethod']?></td>
		</tr>
		<tr>
			<td>Withdrawal Charges:</td>
			<td><?=$data['WithdrawalCharges']?></td>
		</tr>
		<tr>
			<td>Name:</td>
			<td><?=$data['Postal']['Name']?></td>
		</tr>
		<tr>
			<td>Address:</td>
			<td><?=$data['Postal']['Address']?></td>
		</tr>
		<tr>
			<td>Street:</td>
			<td><?=$data['Postal']['Street']?></td>
		</tr>
		<tr>
			<td>City:</td>
			<td><?=$data['Postal']['City']?></td>
		</tr>
		<tr>
			<td>Postal Code:</td>
			<td><?=$data['Postal']['Zip']?></td>
		</tr>
		<tr>
			<td>Country:</td>
			<td><?=$data['Postal']['Country']?></td>
		</tr>
<?php }?>		
<?php 
	if($data['WithdrawalMethod']=='bankBuss'){
?>
		<tr>
			<td>Account name:</td>
			<td><?=$data['AccountNameBuss']?></td>
		</tr>
		<tr>
			<td>Sort code: </td>
			<td><?=$data['SortCodeBuss']?></td>	
		</tr>
		<tr>
			<td>Account number:</td>
			<td><?=$data['AccountNumberBuss']?></td>
		</tr>
		<tr>
			<td>Company number:</td>
			<td><?=$data['CompanyNumberBuss']?></td>
		</tr>
		<tr>
			<td>Company name:</td>
			<td><?=$data['CompanyNameBuss']?></td>
		</tr>
<?php }?>		<tr>
			<td>Reference:</td>
			<td><strong><?=$data['Reference']?></strong></td>
		</tr>
		<tr>
			<td>Amount:</td>
			<td><?=$data['Amount']?></td>
		</tr>
		<tr>
			<td>Currency:</td>
			<td><?=$data['Currency']?></td>
		</tr>		
</table>
<p><strong><u><?=$t("Deposits/Withdrawals")?></u></strong></p>
<blockquote>
<ul>

<li><?=$t("All deposits and withdrawals need to be verified and cleared, please see relevant sections when you login.")?></li>
<li><?=$t("VERY IMPORTANT: Please make sure to INCLUDE your CUSTOMER REFERENCE with your deposit, which you can find when you complete FUNDING on your account page, so that we can credit your account appropriately.")?></li>
<li><?=$t("We cannot be held liable if you send us money with no reference and have not completed a deposit request via your account (though with recorded delivery we can attempt to return any such fiat or solve such matters).")?></li>
<li><?=$t("We cannot be held liable if you send us fiat with no reference, no deposit request, and no recorded delivery, and will treat such activity as suspicious and report it to the relevant authorities.")?></li>
</ul>  
<span><?=$t("When we receive your funds we verify with your deposit request and credit your IBWT account the amount.")?></span><br>
<br>
<p><strong><?=$t("Deposits")?></strong></p>
<ul class="unstyled">
<li><?=$t("You mail fiat via Royal Mail.")?></li>
<li><?=$t("Fiat deposits are currently done via Royal Mail.")?>
- <a href="http://www.royalmail.com/parcel-despatch-low" target="_blank"><?=$t("Parcel despatch.")?></a></li>
<li><?=$t("Please make sure you read Royal Mails instructions for mailing fiat.")?> - <a href="http://www.royalmail.com/business/help-and-support/what-is-the-best-way-to-send-money-or-jewellery" target="_blank"><?=$t("Royal Mail - What is the best way to send money or jewellery.")?></a></li>
<li><?=$t("We strongly recommend that you pay for Royal Mail compensations, relevent charges can be found here.")?> - <a href="http://www.royalmail.com/personal/uk-delivery/special-delivery"><?=$t("Royal Mail - Special delivery.")?></a></li>

<li><?=$t("Royal Mail offers extra services which you may or may not want to use, such as earlier delivery (by 9am (more expensive but faster) or 2nd class mail (cheaper but slower)).")?></li>
<li><a href="http://www.royalmail.com/parcel-despatch-low/uk-delivery/special-delivery" target="_blank"><?=$t("Choose your options")?></a> or <a href="http://www.royalmail.com/parcel-despatch-low/uk-delivery/royal-mail-signed-2nd-class" target="_blank"><?=$t("2nd Class Mail")?></a></li>
<li><?=$t("Royal Mail offers compensation cover of up to ")?>&pound;10,000. - <a href="http://www.royalmail.com/sites/default/files/RM%20Special%20Delivery%209am_Terms%20and%20Conditions_April%2012_0.pdf" target="_blank"><?=$t("Royal Mail Terms of Service.")?></a></li>
<li><?=$t("Once fiat amounts are received your account gets credited the same amount, just the same as doing a bank transfer, without the bank.")?></li>
</ul>
<p><strong><?=$t("Withdrawals")?></strong></p>
<ul class="unstyled">
<li><?=$t("We charge customers the relevant fee that Royal Mail charges to cover the withdrawal amount respectively.")?></li>
<li><?=$t("This charge is made to your IBWT account.")?></li>
<li><?=$t("If you do not have enough to cover the Royal Mail fee in your IBWT account then your withdrawal will not be processed and you will be notified via email.")?></li>
<li><?=$t("We store all fiat via safety deposit box services.")?></li>
</ul>
</blockquote>
<p><strong><u><?=$t("Time Delays")?></u></strong></p>

<blockquote>
<u>GBP / USD / EUR</u>
<ul >
<li><?=$t("    Transfers are only processed weekdays, barring bank holidays.")?></li>
<li><?=$t("    It can take us up to 24 hours to verify and confirm your deposit request once received. Royal Mail takes 1-4 days to deliver, depending upon your choice of 1st or 2nd class.")?></li>
<li><?=$t("    It can take us up to 24 hours to verify, confirm and start the process for your withdrawal requests.")?></li>
<li><?=$t("    It can then take Royal Mail 1-3 days to deliver your withdrawal (we always use 1st Class).")?></li>
<li><?=$t("    We are not liable for Royal Mail incidents.")?></li>
</ul>
<u><?=$t("Bitcoin")?></u>
<ul ><li><?=$t("Bitcoin deposits and withdrawals are subject to the Bitcoin protocol.")?></li></ul>
<u><?=$t("Litecoin")?></u>
<ul ><li><?=$t("Litecoin deposits and withdrawals are subject to the Litecoin protocol.")?></li></ul>
</blockquote>
<p>
<strong>1st Class</strong> <a href="http://www.royalmail.com/price-finder" target="_blank">Price Finder</a><br>
									&pound;50 = &pound;1.70<br>
									&pound;500 = &pound;6.22<br>
									&pound;1,000 = &pound;19.84<br>
									&pound;2,500 = &pound;23.34<br>
<br>
								<a href="http://www.postoffice.co.uk/postal-orders" target="_blank">Postal Order</a><br>
									&pound;0.50 - &pound;4.99 = 50p<br>
									&pound;5 - &pound;9.99 = &pound;1.00<br>
									&pound;10.00 - &pound;99.99 = 12.50%<br>
									&pound;100 - &pound;250 = 12.50%<br>
									
</p>						

<a href="/users/funding_btc" class="btn btn-primary">Funding BTC</a>
<a href="/users/funding_ltc" class="btn btn-primary">Funding LTC</a>
<a href="/users/funding_fiat" class="btn btn-primary">Funding Fiat</a>
<a href="/users/transactions" class="btn btn-primary">Transactions</a>