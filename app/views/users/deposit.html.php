<h4>Deposit</h4>

<h5>Hi <?=$user['firstname']?>,</h5>

<p>You have requested to deposit money to <?=COMPANY_URL?>.</p>
<p><strong>Make SURE you deposit to your verified account. Money attempted to be sent to any other account will result in the transaction being blocked and investigated.</strong></p>
<?php
if($data['DepositMethod']=='post'){
?>
<p style="color:red ">Please make SURE you copy/paste and print the boxed information, or write it clearly and INCLUDE either with your deposit.</p>
<blockquote>
<strong>Registered Address:</strong>
<p>IBWT JD Ltd<br>
	 31 North Down Crescent<br>
	 Keyham, Plymouth<br>
	 Devon, PL2 2AR<br>
   United Kingdom</p>
</blockquote>
<?php }?>
<?php
if($data['DepositMethod']=='okpay'){
?>
<blockquote>
<p>Send payment to: deposit@ibwt.co.uk through <a href="http://okpay.com" target="_blank"><strong>OKPAY</strong></a></p>
</blockquote>
<?php }?>
<table style="border:2px solid black ">
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
<li><?=$t("It can take us up to 24 hours to verify and confirm your deposit request once received. Royal Mail takes 1-4 days to deliver, depending upon your choice of 1st or 2nd class.")?></li>
<li><?=$t("It can take us up to 24 hours to verify, confirm and start the process for your withdrawal requests.")?></li>
<li><?=$t("It can then take Royal Mail 1-3 days to deliver your withdrawal (we always use 1st Class).")?></li>
<li><?=$t("We are not liable for Royal Mail incidents.")?></li>
</ul>
<u><?=$t("Bitcoin")?></u>
<ul ><li><?=$t("Bitcoin deposits and withdrawals are subject to the Bitcoin protocol.")?></li></ul>
<u><?=$t("Litecoin")?></u>
<ul ><li><?=$t("Litecoin deposits and withdrawals are subject to the Litecoin protocol.")?></li></ul>
</blockquote>


<a href="/users/funding_btc" class="btn btn-primary">Funding BTC</a>
<a href="/users/funding_ltc" class="btn btn-primary">Funding LTC</a>
<a href="/users/funding_fiat" class="btn btn-primary">Funding Fiat</a>
<a href="/users/transactions" class="btn btn-primary">Transactions</a>