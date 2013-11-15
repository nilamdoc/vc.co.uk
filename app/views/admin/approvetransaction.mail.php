<div style="background-color:#eeeeee;height:50px;padding-left:20px;padding-top:10px">
	<img src="https://<?=COMPANY_URL?>/img/<?=COMPANY_URL?>.gif" alt="<?=COMPANY_URL?>">
</div>
<h4>Hi <?=$user['firstname']?>,</h4>

<p>Your deposit has been approved <?=COMPANY_URL?>.</p>
<table>
		<tr>
			<td>Reference:</td>
			<td><strong><?=$Transactions['Reference']?></strong></td>
		</tr>
		<tr>
			<td>Amount Received:</td>
			<td><?=$Transactions['AmountApproved']?></td>
		</tr>
		<tr>
			<td>Currency:</td>
			<td><?=$Transactions['Currency']?></td>
		</tr>		
</table>


<p>Thanks,<br>
<?=NOREPLY?></p>

<p>P.S. Please do not reply to this email. </p>
	<p>If you did not initiate this action please contact IBWT as soon as possible via support@ibwt.co.uk or telephone 07914 446125.</p>
<p>We do not spam. </p>