<div style="background-color:#eeeeee;height:50px;padding-left:20px;padding-top:10px">
	<img src="https://<?=COMPANY_URL?>/img/<?=COMPANY_URL?>.gif" alt="<?=COMPANY_URL?>">
</div>
<h4>Hi,</h4>

<p>Please confirm your OKPAY email address associated with your email address:</p>

<p>Open the page https://<?=$_SERVER['HTTP_HOST'];?>/users/settings/<br>
Under Financial Details:<br>
Enter this verification number: <?=$data['okpay.verify']?>
</p>

<p>Thanks,<br>
<?=NOREPLY?></p>

<p>P.S. Please do not reply to this email. </p>
<p>This email was sent to you as you tried to register on <?=COMPANY_URL?> with the email address. 
If you did not register, then you can delete this email.</p>
<p>We do not spam. </p>
