<h4>Withdraw</h4>

<h5>Hi <?=$user['firstname']?>,</h5>

<p>You have requested to withdraw money from <?=COMPANY_URL?>.</p>
<p><strong>Thank you, your request has been sent for clearance.</strong></p>
<table>
<?php 
	if($data['WithdrawalMethod']=='bank'){
?>
		<tr>
			<td>Account name:</td>
			<td><?=$data['AccountName']?></td>
		</tr>
		<tr>
			<td>Sort code: </td>
			<td><?=$data['SortCode']?></td>	
		</tr>
		<tr>
			<td>Account number:</td>
			<td><?=$data['AccountNumber']?></td>
		</tr>
<?php }?>
<?php 
	if($data['WithdrawalMethod']=='post'){
?>
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
			<td>Zip:</td>
			<td><?=$data['Postal']['Zip']?></td>
		</tr>
		<tr>
			<td>Country:</td>
			<td><?=$data['Postal']['Country']?></td>
		</tr>
<?php }?>		
		<tr>
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
<li><?=$t("Transfers are only processed weekdays, barring bank holidays.")?></li>
<li><?=$t("It can take us up to 24 hours to verify and confirm your deposit request. Customers then have 24 hours to make their deposit. If a deposit is not made in the 24 window then IBWT assumes you have cancelled your deposit request and you will need to make request if you wish to deposit.")?></li>
<li><?=$t("If your bank does not subscribe to Faster Payments (most UK banks do) then please let us know.")?></li>
<li><?=$t("It can take us up to 24 hours to verify, confirm and start the process transfer for your withdrawal requests.")?></li>
<li><?=$t("If the Customer's bank subscribes to Faster Payments the money will reach their account usually within 24 hours but can sometimes take up to close of business the next working day. Otherwise payments take 4 working days to process.")?></li>
</ul>
<u><?=$t("Bitcoin")?></u>
<ul ><li><?=$t("Bitcoin deposits and withdrawals are subject to the Bitcoin protocol.")?></li></ul>
<u><?=$t("Litecoin")?></u>
<ul ><li><?=$t("Litecoin deposits and withdrawals are subject to the Litecoin protocol.")?></li></ul>
</blockquote>

<p><strong><u><?=$t("Security")?></u></strong></p>
<blockquote>

<a href="/users/funding_btc" class="btn btn-primary">Funding BTC</a>
<a href="/users/funding_ltc" class="btn btn-primary">Funding LTC</a>
<a href="/users/funding_fiat" class="btn btn-primary">Funding Fiat</a>
<a href="/users/transactions" class="btn btn-primary">Transactions</a>