<div style="background-color:#eeeeee;height:50px;padding-left:20px;padding-top:10px">
	<img src="https://<?=COMPANY_URL?>/img/logo-<?=COMPANY_URL?>.png" alt="<?=COMPANY_URL?>">
</div>
<h4>Hi <?=$name?>,</h4>

<p>Please confirm your email address associated at <?=COMPANY_URL?> by clicking the following link:</p>

<p><a href="https://<?=$_SERVER['HTTP_HOST'];?>/users/confirm/<?=$email?>/<?=$verification?>">
https://<?=$_SERVER['HTTP_HOST'];?>/users/confirm/<?=$email?>/<?=$verification?></a></p>

<p>Or use this confirmation code: <?=$verification?> for your email address: <?=$email?> on the page 
https://<?=$_SERVER['HTTP_HOST'];?>/users/email</p>

</p>

<p>Thanks,<br>
<?=NOREPLY?></p>

<p>P.S. Please do not reply to this email. </p>
<p>This email was sent to you as you tried to register on <?=COMPANY_URL?> with the email address. 
If you did not register, then you can delete this email.</p>
<p>We do not spam. </p>
