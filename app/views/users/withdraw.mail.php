<div style="background-color:#eeeeee;height:50px;padding-left:20px;padding-top:10px">
	<img src="https://<?=COMPANY_URL?>/img/<?=COMPANY_URL?>.gif" alt="<?=COMPANY_URL?>">
</div>
<h4>Hi <?=$user['firstname']?>,</h4>

<p>You have requested to withdraw money from <?=COMPANY_URL?>.</p>
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
<p><strong><u>Deposits/Withdrawals</u></strong></p>
<blockquote>
<ul>

<li>All deposits and withdrawals need to be verified and cleared, please see relevant sections when you login.</li>

<li><strong>IMPORTANT</strong>: Please make sure to wait for CLEARED deposit requests BEFORE depositing any sterling. As per our Terms Of Use, we cannot be held liable for any charges incurred due to deposits bounced if you have not had your deposit request CLEARED.</li>

<li><strong>VERY IMPORTANT</strong>: Please make sure to INCLUDE your CUSTOMER REFERENCE, which you can find on your account page, so that we can credit your account appropriately.</li>

<u>Reference</u>: <?=$data['Reference']?></ul>
</blockquote>
<p><strong><u>Time Delays</u></strong></p>

<blockquote>
<u>GBP</u>
<ul >
<li>Transfers are only processed weekdays, barring bank holidays.</li>
<li>It can take us up to 24 hours to verify and confirm your deposit request. Customers then have 24 hours to make their deposit. If a deposit is not made in the 24 window then IBWT assumes you have cancelled your deposit request and you will need to make request if you wish to deposit.</li>
<li>If your bank does not subscribe to Faster Payments (most UK banks do) then please let us know.</li>
<li>It can take us up to 24 hours to verify, confirm and start the process transfer for your withdrawal requests.</li>
<li>If the Customer's bank subscribes to Faster Payments the money will reach their account usually within 24 hours but can sometimes take up to close of business the next working day. Otherwise payments take 4 working days to process.</li>
</ul>


<p>Thanks,<br>
<?=NOREPLY?></p>

<p>P.S. Please do not reply to this email. </p>
<p>This email was sent to you as you tried to register on <?=COMPANY_URL?> with the email address. 
If you did not register, then you can delete this email.</p>
<p>We do not spam. </p>