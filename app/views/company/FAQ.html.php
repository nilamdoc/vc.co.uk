<?php
use app\models\Parameters;
$Comm = Parameters::find('first');
?>
<div class="well" style="background-image:url(/img/Stamp.png);background-position:bottom right;background-repeat:no-repeat">
<h3><?=$t("FAQ")?></h3>

<p><strong><u><?=$t("Become a Customer")?></u></strong></p>

<blockquote><?=$t("To become an IBWT customer please click ")?><a href="/users/signup">signup</a>. <?=$t("Registration implies you have read and agreed to our ")?><a href="/company/termsofservice"><?=$t("Terms of Service")?>.</a>
</blockquote>
<p><strong><u><?=$t("Fees")?></u></strong></p>
<blockquote><ul>
<li>We charge <strong><?=$Comm['value']?></strong>% per transaction.</li>
<li><?=$t("If you ")?><strong><?=$t("buy")?></strong><?=$t(" 1 Bitcoin our fee is ")?><strong><?=$Comm['value']/100?></strong><?=$t(" Bitcoins.")?></li>
<li><?=$t("If you ")?><strong><?=$t("sell")?></strong> &pound;100 <?=$t("worth of Bitcoins our fee is ")?><strong><?=$Comm['value']*100?></strong> <?=$t("pence")?>.</li>
</ul>
</blockquote>
<p><strong><u><?=$t("Deposits/Withdrawals")?></u></strong></p>
<blockquote>
<ul>

<li><?=$t("All deposits and withdrawals need to be verified and cleared, please see relevant sections when you login.")?></li>
<li><?=$t("VERY IMPORTANT: Please make sure to INCLUDE your CUSTOMER REFERENCE with your deposit, which you can find when you complete FUNDING on your account page, so that we can credit your account appropriately.")?></li>
<li><?=$t("We cannot be held liable if you send us money with no reference and have not completed a deposit request via your account (though with recorded delivery we can attempt to return any such fiat or solve such matters).")?></li>
<li><?=$t("We cannot be held liable if you send us fiat with no reference, no deposit request, and no recorded delivery, and will treat such activity as suspicious and report it to the relevant authorities.")?></li>
<u><?=$t("Example Reference:")?></u><br>
<?=$t("Account name")?>: <strong>silent bob</strong><br>
<?=$t("Deposit request date")?>: <strong>12/10/13</strong><br>
<?=$t("Reference number")?>: <strong>15828481</strong><br>
<?=$t("Amount")?>: <strong>&pound;xxxx</strong><br>
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
<li><?=$t("Please see ")?><a href="/files/Withdrawal%20Verification.pdf" target="_blank">Withdrawal Verification</a> <?=$t("for instructions on how to input and verify your Proof of Address.")?></li>
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

<p><strong><u><?=$t("Security")?></u></strong></p>
<blockquote>

<ul >
<li><?=$t("IBWT employs two factor authentication (2FA) and time-based one-time password algorithm (TOTP), for login, withdrawals, deposits and settings.")?></li>

<li><?=$t("We also require a level of identification for all customers as per our (link) verification page, and run random security checks on accounts. Any information found to be out of date may result in the account in question to be temporarily suspended until such information is suitably updated.")?></li>

<li><?=$t("If you have any issues please contact IBWT at ")?><a href="mailto:support@<?=COMPANY_URL?> ">support@<?=COMPANY_URL?></a></li>

</ul>
</blockquote>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
</div>