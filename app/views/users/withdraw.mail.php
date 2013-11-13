<div style="background-color:#eeeeee;height:50px;padding-left:20px;padding-top:10px">
	<img src="https://<?=COMPANY_URL?>/img/<?=COMPANY_URL?>.gif" alt="<?=COMPANY_URL?>">
</div>
<h4>Hi <?=$user['firstname']?>,</h4>

<p>You have requested to withdraw money from <?=COMPANY_URL?> through <strong><?=$data['WithdrawalCharges']?></strong>.</p>
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
		<tr>
			<td>Withdrawal Charges:</td>
			<td><?=$data['WithdrawalCharges']?></td>
		</tr>
</table>
<p><strong><u>Deposits/Withdrawals</u></strong></p>
<blockquote>
<ul>

<li>All deposits and withdrawals need to be verified and cleared, please see relevant sections when you login.</li>
<li>VERY IMPORTANT: Please make sure to INCLUDE your CUSTOMER REFERENCE with your deposit, which you can find when you complete FUNDING on your account page, so that we can credit your account appropriately.</li>
<li>We cannot be held liable if you send us money with no reference and have not completed a deposit request via your account (though with recorded delivery we can attempt to return any such fiat or solve such matters).</li>
<li>We cannot be held liable if you send us fiat with no reference, no deposit request, and no recorded delivery, and will treat such activity as suspicious and report it to the relevant authorities.</li>
</ul>  
<span>When we receive your funds we verify with your deposit request and credit your IBWT account the amount.</span><br>
<br>
<p><strong>Deposits</strong></p>
<ul class="unstyled">
<li>You mail fiat via Royal Mail.</li>
<li>Fiat deposits are currently done via Royal Mail.- <a href="http://www.royalmail.com/parcel-despatch-low" target="_blank">Parcel despatch.</a></li>
<li>Please make sure you read Royal Mails instructions for mailing fiat. - <a href="http://www.royalmail.com/business/help-and-support/what-is-the-best-way-to-send-money-or-jewellery" target="_blank">Royal Mail - What is the best way to send money or jewellery.</a></li>
<li>We strongly recommend that you pay for Royal Mail compensations, relevent charges can be found here. - <a href="http://www.royalmail.com/personal/uk-delivery/special-delivery">Royal Mail - Special delivery.</a></li>

<li>Royal Mail offers extra services which you may or may not want to use, such as earlier delivery (by 9am (more expensive but faster) or 2nd class mail (cheaper but slower)).</li>
<li><a href="http://www.royalmail.com/parcel-despatch-low/uk-delivery/special-delivery" target="_blank">Choose your options</a> or <a href="http://www.royalmail.com/parcel-despatch-low/uk-delivery/royal-mail-signed-2nd-class" target="_blank">2nd Class Mail</a></li>
<li>Royal Mail offers compensation cover of up to &pound;10,000. - <a href="http://www.royalmail.com/sites/default/files/RM%20Special%20Delivery%209am_Terms%20and%20Conditions_April%2012_0.pdf" target="_blank">Royal Mail Terms of Service.</a></li>
<li>Once fiat amounts are received your account gets credited the same amount, just the same as doing a bank transfer, without the bank.</li>
</ul>
<p><strong>Withdrawals</strong></p>
<ul class="unstyled">
<li>We charge customers the relevant fee that Royal Mail charges to cover the withdrawal amount respectively.</li>
<li>This charge is made to your IBWT account.</li>
<li>If you do not have enough to cover the Royal Mail fee in your IBWT account then your withdrawal will not be processed and you will be notified via email.</li>
<li>We store all fiat via safety deposit box services.</li>
</ul>
</blockquote>
<p><strong><u>Time Delays</u></strong></p>

<blockquote>
<u>GBP / USD / EUR</u>
<ul >
<li>Transfers are only processed weekdays, barring bank holidays.</li>
<li>It can take us up to 24 hours to verify and confirm your deposit request. Customers then have 24 hours to make their deposit. If a deposit is not made in the 24 window then IBWT assumes you have cancelled your deposit request and you will need to make request if you wish to deposit.</li>
<li>If your bank does not subscribe to Faster Payments (most UK banks do) then please let us know.</li>
<li>It can take us up to 24 hours to verify, confirm and start the process transfer for your withdrawal requests.</li>
<li>If the Customer&#039;s bank subscribes to Faster Payments the money will reach their account usually within 24 hours but can sometimes take up to close of business the next working day. Otherwise payments take 4 working days to process.</li>
</ul>
<u>Bitcoin</u>
<ul ><li>Bitcoin deposits and withdrawals are subject to the Bitcoin protocol.</li></ul>
<u>Litecoin</u>
<ul ><li>Litecoin deposits and withdrawals are subject to the Litecoin protocol.</li></ul>
</blockquote>

<p>Thanks,<br>
<?=NOREPLY?></p>

<p>P.S. Please do not reply to this email. </p>
<p>This email was sent to you as you tried to register on <?=COMPANY_URL?> with the email address. 
If you did not register, then you can delete this email.</p>
<p>We do not spam. </p>