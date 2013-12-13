<?php
use li3_qrcode\extensions\action\QRcode;
	$qrcode = new QRcode();
?>
<div class="span10">
<h1>Deposit</h1>
<h2>Litecoin Address</h2>
<h2>To add bitcoins please send payment to:</h2>
<h1><?=$address?></h1>
<?php	$qrcode->png($address, QR_OUTPUT_DIR.$address.'.png', 'H', 7, 2);?>
<img src="<?=QR_OUTPUT_RELATIVE_DIR.$address?>.png" style="border:1px solid black"><br><br>
			<a href="/ATM/dashboard" class="btn btn-success btn-large">Dashboard</a>											
			<a href="/ATM/index" class="btn btn-danger btn-large">Logout</a>											
</div>