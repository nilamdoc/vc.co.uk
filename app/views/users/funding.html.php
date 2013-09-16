<?php
use li3_qrcode\extensions\action\QRcode;
	$qrcode = new QRcode();
?>
<h4>Funding</h4>
<div class="row">
	<div class="span5">
		<div class="navbar">
			<div class="navbar-inner">
			<a class="brand" href="#"><?=$t('Deposit bitcoins')?> </a>
			</div>
			<table class="table table-condensed table-bordered table-hover" style="margin-top:-20px">
				<tr style="background-color:#CFFDB9">
					<td><?=$t("Bitcoin Address")?></td>
				</tr>
				<tr>
					<td>To add bitcoins please send payment to: <strong><?=$address?></strong></td>
				</tr>
				<tr>
				<?php	$qrcode->png($address, QR_OUTPUT_DIR.$address.'.png', 'H', 7, 2);?>
					<td style="text-align:center ">
						<img src="<?=QR_OUTPUT_RELATIVE_DIR.$address?>.png" style="border:1px solid black">
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="span5">
		<div class="navbar">
			<div class="navbar-inner">
			<a class="brand" href="#"><?=$t('Withdraw bitcoins')?> </a>
			</div>
		</div>
	</div>	
</div>
