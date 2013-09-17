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
					<td><?=$t("To add bitcoins please send payment to: ")?><strong><?=$address?></strong></td>
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
	<div class="span5">
		<div class="navbar">
			<div class="navbar-inner">
			<a class="brand" href="#"><?=$t('Withdraw bitcoins')?> </a>
			</div>
			<table class="table table-condensed table-bordered table-hover" style="margin-top:-20px">
				<tr style="background-color:#CFFDB9">
					<td><?=$t('Bitcoin balance')?></td>
				</tr>
				<tr>
					<td><strong><?=number_format($details['balance.BTC'],8)?> BTC</strong><br><br></td>
				</tr>
				<tr>
					<td style="height:280px ">
						<form action="/users/payment/">
						<div class="input-append">
						<label for="Bitcoinaddress">Bitcoin Address</label>
						<input type="text" name="bitcoinaddress" placeholder="15AXfnf7hshkwgzA8UKvSyjpQdtz34H9LE" class="span4" id="Bitcoinaddress" title="To Address" data-content="This is the Bitcoin Address of the recipient."/><span class="add-on">
						<a href="#" onclick="setwebcam();"><i class="icon-qrcode"></i></a></span></div>
						<div id="outdiv">
						<p class="helptext2" >select webcam or image scanning</p>
						</div>
						<div id="result"></div>
						<small class="help-block">Enter The Bitcoin Address of the Recipient</small>
							<?=$this->form->field('amount', array('label'=>'Amount', 'placeholder'=>'0.0', 'class'=>'span2')); ?>
						</form>
					</td>
				</tr>
			</table>
		</div>
	</div>	
</div>
<script type="text/javascript" src="/js/webqr.js"></script>