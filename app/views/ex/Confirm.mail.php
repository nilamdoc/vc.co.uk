<div style="background-color:#eeeeee;height:50px;padding-left:20px;padding-top:10px">
	<img src="http://ibwt.co.uk/img/VirtCurr.gif" alt="National Bitcoin">
</div>
<h4>Hi <?=$name?>,</h4>

<p>Please confirm your email address associated at rbitco.in by clicking the following link:</p>

<p><a href="https://<?=$_SERVER['HTTP_HOST'];?>/users/confirm/<?=$email?>/<?=$verification?>">https://<?=$_SERVER['HTTP_HOST'];?>/users/confirm/<?=$email?>/<?=$verification?></a></p>

<p>Or use this confirmation code: <?=$verification?> for your email address: <?=$email?> on the page https://<?=$_SERVER['HTTP_HOST'];?>/users/email</p>

<p>Once you confirm your email address, you can send all your bitcoins to <?=$bitcoinaddress?>. <br>
You will see the balance of this on the server after sign in on https://<?=$_SERVER['HTTP_HOST'];?>/users/accounts<br>
Your account has also been credited with <?=number_format($registerSelf,7);?> BTC.<br>
You can make purchases from this on any website which supports bitcoin purchase.<br>
</p>

<p>Thanks,<br>
No-reply</p>

<p>P.S. Please do not reply to this email. </p>
<p>This email was sent to you as you tried to register on <?=$_SERVER['HTTP_HOST'];?> with the email address. If you did not register, then you can delete this email.</p>
<p>We do not spam. </p>
