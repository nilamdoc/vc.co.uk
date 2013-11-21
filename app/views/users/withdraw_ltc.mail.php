<div style="background-color:#eeeeee;height:50px;padding-left:20px;padding-top:10px">
	<img src="https://<?=COMPANY_URL?>/img/<?=COMPANY_URL?>.gif" alt="<?=COMPANY_URL?>">
</div>
<h4>Hi <?=$data['username']?>,</h4>
<p>You have requested to withdraw <strong><?=abs($data['Amount'])?> LTC</strong> from <?=COMPANY_URL?>.</p>
<p>Click on the link below to confirm the transfer. </p>
<p>If you did not authorize this withdrawal to the litecoin address: <strong><?=$data['address']?></strong> please <strong style="color:#FF0000">do not</strong> click on the link.</p>
<a href="https://<?=COMPANY_URL?>/users/paymentltcconfirm/<?=$data['verify.payment']?>">https://<?=COMPANY_URL?>/users/paymentltcconfirm/<?=$data['verify.payment']?></a>

<p>You will be asked for your main password on the page following the link to authorize the transfer. This is an added security feature IBWT employs to secure your bitcoins from hackers / spammers.</p>

<p>Thanks,<br>
<?=NOREPLY?></p>

<p>P.S. Please do not reply to this email. </p>
<p>This email was sent to you as you tried to withdraw BTC from <?=COMPANY_URL?> with the email address. 
<p>We do not spam. </p>
