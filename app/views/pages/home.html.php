<?php
use app\models\Parameters;
use lithium\core\Environment; 
$Comm = Parameters::find('first');
?>
<?php 
if(substr(Environment::get('locale'),0,2)=="en"){$locale = "en";}else{$locale = Environment::get('locale');}
?>
<div class="row container">
	<div class="well span8" >
	<table>
		<tr>
			<td><img src="/img/IBWTLogo.png" width="240" alt="In Bitcoin We Trust"></td>
			<td><!-- Begin OKPAY Logo --><A HREF="https://www.okpay.com/?rbp=IBWT" target="_blank"><IMG SRC="https://www.okpay.com/img/partners/rbp_banner.gif" BORDER="0" ALT="Sign up for OKPAY and start accepting payments instantly."></A><!-- End OKPAY Logo --></td>
		</tr>
	</table>
	<blockquote>"The day science begins to study non-physical phenomena, it will make more progress in one decade than in all the previous 
	centuries of its existence." <small>Nikola Tesla</small></blockquote>
	<p class="alert" style="color:#111111;background-color:#FCC952 ;font-size:16px;font-weight:bold ">One wonders how applicable Bitcoin is to Nikola Tesla's statement. Here at IBWT we plan to help put it to the test, by enabling you, our customers, to trade your Bitcoin for sterling with each other in a secure and trusted environment.</p>
	<h5>IBWT is a UK Bitcoin/Virtual Currency exchange, offering a fully regulated, secure method, for individuals and businesses to buy or sell bitcoins.</h5>
	<ul>
			<li>Fees are <strong><?=$Comm['value']?></strong>% per transaction</li>
			<li>Simple verification means you could be a full customer in a matter of days</li>
			<li>Security ensured with Cold Storage, SSL 256bit encryption & 2FA</li>
			<li>Dedicated Server for an enhanced customer experience</li>
			<li>Deposits via <A HREF="/okpay" target="_blank">OKPAY</A> or secure mail services.</li>
			<li>Withdrawal via <A HREF="/okpay" target="_blank">OKPAY</A>, secure mail services or via banks.</li>

	</ul>
	<h3>About Bitcoin</h3>
	<ul>
		<li><a href="http://www.coindesk.com/information/" target="_blank">Beginners Guide To Bitcoin</a></li>
		<li><a href="http://bitcoin.org/en/" target="_blank">Bitcoin Organization</a></li>
		<li><a href="https://en.bitcoin.it/wiki/Main_Page" target="_blank">Bitcoin Wiki</a></li>
		<li><a href="http://bitcoinmagazine.com/" target="_blank">Bitcoin Magazine</a></li>
	</ul>
	<h3>Security</h3>
	<ul>
		<li>We use <strong>Two Factor Authentication</strong> for your account to login to <?=COMPANY_URL?>.</li>
		<li>We use <strong>Time-based One-time Password Algorithm (TOTP)</strong> for login, withdrawal/deposits and settings.</li>
		<li>Keep your Bitcoins safe and secure - <a href="http://bitcoin.org/en/secure-your-wallet" target="_blank">Security</a>.</li>
	</ul>
<h3>Find us</h3>
<ul class="unstyled">
	<li>
		<a  target="_blank" href="https://www.facebook.com/pages/IBWT/425446187570505"><img src="/img/Facebook-logo.png" alt="Facebook" width="30px" title="Facebook"></a>
		&nbsp;&nbsp;
		<a target="_blank" href="https://twitter.com/IBWTofficial"><img src="/img/twitter.jpg" alt="Twitter" width="30px" title="Twitter"></a>
		&nbsp;&nbsp;
		<a target="_blank" href="http://www.reddit.com/r/IBWTofficial/"><img src="/img/reddit.jpg" alt="Reddit" width="30px" title="Reddit"></a>
		&nbsp;&nbsp;
<a href="https://bitcointalk.org/index.php?topic=397625.0" target="_blank"><img src="/img/bitcointalk_logo.jpg.png" alt="Bitcoin talk" width="30px" title="bitcoin talk"></a>
		&nbsp;&nbsp;
		<a href="https://plus.google.com/b/100582829535245250566/100582829535245250566/about?hl=en" target="_blank"><img src="/img/google.png" width="30px" alt="Google+" title="Google+"></a>
	</li>
	
</ul>

	</div>
	<div class="span3" style="min-height:732px;border:1px solid gold;padding:4px ">
		<div style="overflow:auto;height:605px">
			<ul class="unstyled">
				<li class="alert alert-danger"><strong>Visit our <a href="/<?=$locale?>/virtualoffice">Virtual Office</a> for the latest IBWT <a href="/<?=$locale?>/news">News</a> and Info.</strong></li>
			<div style="text-align:center ">
					<a href="/<?=$locale?>/virtualoffice"><img src="/img/VO-Office.jpg" width="225px"  style="margin-bottom:10px;margin-top:-10px"></a>
			</div>				
				<li class="alert" style="background-color:#FCC952"><a href="https://www.youtube.com/watch?v=LP4GSvQUtBw" target="_blank"><strong>Bitcoin - The Future Currency</strong></a></li>
			</ul>
		<div style="text-align:center ">
<!-- Begin OKPAY Seal Logo --><a href="https://www.okpay.com/account/user/456908980" target="_blank"><img src="https://www.okpay.com/img/seals/seal01.png" width="100"  height="100" border="0" style="margin-bottom:10px" alt="Verify OKPAY user information."></a>
	<a href="/okpay"><img src="/img/okpay-excp-b.png" width="100"  height="100" border="0" style="margin-bottom:10px" alt="Verify OKPAY user information.">
</a><!-- End OKPAY Seal Logo --><br>
<!--		<a href="http://www.bitcointrezor.com/" target="_blank"><img src="/img/trezor.png" title="Trezor, the Bitcoin Safe"></a><br> -->
		<a href="http://bitcoinmagazine.com/" target="_blank"><img src="/img/BMlogo.jpg" title="Bitcoin Magazine"  style="margin-bottom:10px" width="150"></a><br>
<a href="https://multibit.org/" target="_blank"><img src="/img/bitcointalk_logo.jpg.png" width="170px" alt="Multibit"/></a><br>
<!--		<a href="https://bitcoinfoundation.org/" target="_blank"><img src="/img/bitcoin-foundation.jpg" alt="Bitcoin Foundation" width="170px"></a><br>
-->
		</div>
		</div>

		<img src="/img/Stamp.png" class="pull-right" width="250" style="padding:1px;">
	</div>
<!--
<h3>News</h3>
<ul>
	<li><a href="/files/News Release 27-09-13.pdf">Launching on 30th September 2013</a></li>
	<li>Please find our recent news <a href="/news">here.</a>.</li>
</ul>
-->

<br>
<br>
<br>
<br>
</div>