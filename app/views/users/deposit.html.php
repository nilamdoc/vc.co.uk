<h4>Deposit</h4>

<h5>Hi <?=$user['firstname']?>,</h5>

<p>You have requested to deposit money to <?=COMPANY_URL?>.</p>
<p><strong>Make SURE you deposit from your verified account. Money sent from any other account will result in the transaction being blocked and investigated.</strong></p>
<table>
		<tr>
			<td>Registered Address: </td>
			<td>IBWT JD Ltd<br>
				 31 North Down Crescent<br>
				 Keyham, Plymouth<br>
				 Devon, PL2 2AR<br>
				United Kingdom</td>
		</tr>
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

<li><strong><?=$t("IMPORTANT")?></strong>: <?=$t("Please make sure to wait for CLEARED deposit requests BEFORE depositing any sterling. As per our Terms Of Use, we cannot be held liable for any charges incurred due to deposits bounced if you have not had your deposit request CLEARED.")?></li>

<li><strong><?=$t("VERY IMPORTANT")?></strong>: <?=$t("Please make sure to INCLUDE your CUSTOMER REFERENCE, which you can find on your account page, so that we can credit your account appropriately.")?></li>

<u><?=$t("Example")?></u>: <?=$data['Reference']?></ul>
</blockquote>
<p><strong><u><?=$t("Time Delays")?></u></strong></p>

<blockquote>
<u>GBP</u>
<ul >
<li><?=$t("Transfers are only processed weekdays, barring bank holidays.")?></li>
<li><?=$t("It can take us up to 24 hours to verify and confirm your deposit request. Customers then have 24 hours to make their deposit. If a deposit is not made in the 24 window then IBWT assumes you have cancelled your deposit request and you will need to make request if you wish to deposit.")?></li>
<li><?=$t("If your bank does not subscribe to Faster Payments (most UK banks do) then please let us know.")?></li>
<li><?=$t("It can take us up to 24 hours to verify, confirm and start the process transfer for your withdrawal requests.")?></li>
<li><?=$t("If the Customer's bank subscribes to Faster Payments the money will reach their account usually within 24 hours but can sometimes take up to close of business the next working day. Otherwise payments take 4 working days to process.")?></li>
</ul>
<a href="/users/funding_btc" class="btn btn-primary">Funding BTC</a>
<a href="/users/funding_ltc" class="btn btn-primary">Funding LTC</a>
<a href="/users/funding_fiat" class="btn btn-primary">Funding Fiat</a>
<a href="/users/transactions" class="btn btn-primary">Transactions</a>