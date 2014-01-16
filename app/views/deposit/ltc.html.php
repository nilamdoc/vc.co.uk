<?php
use lithium\util\String;
use li3_qrcode\extensions\action\QRcode;
	$qrcode = new QRcode();
?>
<h4>Deposit - LTC </h4>

		<div id="collapseOne" class="accordion-body ">
			<div class="accordion-inner">
				<div class="row">
					<div class="span5">
						<div class="navbar">
							<div class="navbar-inner1">
							<a class="brand" href="#"><?=$t('Deposit litecoins')?> </a>
							</div>
							<table class="table table-condensed table-bordered table-hover" style="margin-top:-20px">
								<tr style="background-color:#CFFDB9">
									<td><?=$t("Litecoin Address")?></td>
								</tr>
								<tr>
									<td><?=$t("To add litecoins please send payment to: ")?><strong><?=$address?></strong></td>
								</tr>
								<tr>
								<?php	$qrcode->png($address, QR_OUTPUT_DIR.$address.'.png', 'H', 7, 2);?>
									<td style="text-align:center ;height:280px;vertical-align:middle ">
										<img src="<?=QR_OUTPUT_RELATIVE_DIR.$address?>.png" style="border:1px solid black">
									</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
