<div style="background-color:#eeeeee;height:50px;padding-left:20px;padding-top:10px">
	<img src="https://<?=COMPANY_URL?>/img/<?=COMPANY_URL?>.gif" alt="<?=COMPANY_URL?>">
</div>
<h4>Hi <?=$user['firstname']?>,</h4>

<p>Your deposit has been approved by <?=COMPANY_URL?>. Please mae a deposit now as per the details below. Once we see the funds in our account, we will credit your account at <?=COMPANY_URL?>.</p>
<p>You can also send a scanned receipt of your deposit to support@ibwt.co.uk.</p>
<table>
		<tr>
			<td>Sort code: </td>
			<td>07-71-99</td>	
		</tr>
		<tr>
			<td>Account number:</td>
			<td>59044675</td>
		</tr>
		<tr>
			<td>Reference:</td>
			<td><strong><?=$Transactions['Reference']?></strong></td>
		</tr>
		<tr>
			<td>Amount:</td>
			<td><?=$Transactions['Amount']?></td>
		</tr>
		<tr>
			<td>Currency:</td>
			<td><?=$Transactions['Currency']?></td>
		</tr>		
</table>


<p>Thanks,<br>
<?=NOREPLY?></p>

<p>P.S. Please do not reply to this email. </p>
<p>This email was sent to you as you tried to register on <?=COMPANY_URL?> with the email address. 
If you did not register, then you can delete this email.</p>
<p>We do not spam. </p>