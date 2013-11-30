<?php
use app\models\Parameters;
use lithium\core\Environment; 
$Comm = Parameters::find('first');
?>
<?php 
if(substr(Environment::get('locale'),0,2)=="en"){$locale = "en";}else{$locale = Environment::get('locale');}
?>
<div class="row">
	<div class="well span8" >
	<h3>In Bitcoin We Trust (IBWT)</h3>
	<blockquote>"The day science begins to study non-physical phenomena, it will make more progress in one decade than in all the previous 
	centuries of its existence." <small>Nikola Tesla</small></blockquote>
	<p class="alert alert-error" style="font-size:16px;font-weight:bold ">One wonders how applicable Bitcoin is to Nikola Tesla's statement. Here at IBWT we plan to help put it to the test, by enabling you, our customers, to trade your Bitcoin for sterling with each other in a secure and trusted environment.</p>
	<h5>IBWT is a UK Bitcoin/Virtual Currency exchange, offering a fully regulated, secure method, for individuals and businesses to buy or sell bitcoins.</h5>
	<ul>
			<li>Fees are <strong><?=$Comm['value']?></strong>% per transaction</li>
			<li>Simple verification means you could be a full customer in a matter of days</li>
			<li>Security ensured with Cold Storage, SSL 256bit encryption & 2FA</li>
			<li>Dedicated Server for an enhanced customer experience</li>
			<li>Deposits & Withdrawals via secure mail services.</li>
			<li>Services only available to UK residents</li>
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
	<li><a  target="_blank" href="https://www.facebook.com/pages/IBWT/425446187570505"><img src="/img/Facebook-logo.png" alt="Facebook" width="30px"></a></li>
</ul>

	</div>
	<div class="span3 bs-docs-site" style="min-height:732px; ">
		<div style="overflow:auto;height:425px">
			<ul class="unstyled">
				<li><a href="/<?=$locale?>/news">News</a></li>
				<li><a href="https://www.youtube.com/watch?v=LP4GSvQUtBw" target="_blank">Explanation: Bitcoin - The Future Currency</a></li>
			</ul>
		<a href="http://www.bitcointrezor.com/" target="_blank"><img src="/img/trezor.png" title="Trezor, the Bitcoin Safe"></a>
		</div>

		<img src="/img/Stamp.png" class="pull-right" width="300" style="padding:1px;">
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