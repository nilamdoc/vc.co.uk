<?php
use li3_qrcode\extensions\action\QRcode;
	$qrcode = new QRcode();
?>
<script type="text/javascript" src="/js/qrcode/grid.js"></script>
<script type="text/javascript" src="/js/qrcode/version.js"></script>
<script type="text/javascript" src="/js/qrcode/detector.js"></script>
<script type="text/javascript" src="/js/qrcode/formatinf.js"></script>
<script type="text/javascript" src="/js/qrcode/errorlevel.js"></script>
<script type="text/javascript" src="/js/qrcode/bitmat.js"></script>
<script type="text/javascript" src="/js/qrcode/datablock.js"></script>
<script type="text/javascript" src="/js/qrcode/bmparser.js"></script>
<script type="text/javascript" src="/js/qrcode/datamask.js"></script>
<script type="text/javascript" src="/js/qrcode/rsdecoder.js"></script>
<script type="text/javascript" src="/js/qrcode/gf256poly.js"></script>
<script type="text/javascript" src="/js/qrcode/gf256.js"></script>
<script type="text/javascript" src="/js/qrcode/decoder.js"></script>
<script type="text/javascript" src="/js/qrcode/qrcode.js"></script>
<script type="text/javascript" src="/js/qrcode/findpat.js"></script>
<script type="text/javascript" src="/js/qrcode/alignpat.js"></script>
<script type="text/javascript" src="/js/qrcode/databr.js"></script>
<style>
.Address_success{background-color: #9FFF9F;font-weight:bold}
</style>
<script type="text/javascript">
var gCtx = null;
	var gCanvas = null;

	var imageData = null;
	var ii=0;
	var jj=0;
	var c=0;
	
	
function dragenter(e) {
  e.stopPropagation();
  e.preventDefault();
}

function dragover(e) {
  e.stopPropagation();
  e.preventDefault();
}
function drop(e) {
  e.stopPropagation();
  e.preventDefault();

  var dt = e.dataTransfer;
  var files = dt.files;

  handleFiles(files);
}

function handleFiles(f)
{
	var o=[];
	for(var i =0;i<f.length;i++)
	{
	  var reader = new FileReader();

      reader.onload = (function(theFile) {
        return function(e) {
          qrcode.decode(e.target.result);
        };
      })(f[i]);

      // Read in the image file as a data URL.
      reader.readAsDataURL(f[i]);	}
}
	
function read(a)
{
 $("#bitcoinaddress").val(a);
 $("#SendAddress").html(a); 
 $("#bitcoinaddress").addClass("Address_success");
 $("#bitcoinAddressWindow").hide();
}	
	
function loadDiv()
{
	$("#bitcoinAddressWindow").show();
	initCanvas(300,200);
	qrcode.callback = read;
	qrcode.decode("");
}

function initCanvas(ww,hh)
	{
		gCanvas = document.getElementById("qr-canvas");
		gCanvas.addEventListener("dragenter", dragenter, false);  
		gCanvas.addEventListener("dragover", dragover, false);  
		gCanvas.addEventListener("drop", drop, false);
		var w = ww;
		var h = hh;
		gCanvas.style.width = w + "px";
		gCanvas.style.height = h + "px";
		gCanvas.width = w;
		gCanvas.height = h;
		gCtx = gCanvas.getContext("2d");
		gCtx.clearRect(0, 0, w, h);
		imageData = gCtx.getImageData( 0,0,320,240);
	}

	function passLine(stringPixels) { 
		//a = (intVal >> 24) & 0xff;

		var coll = stringPixels.split("-");
	
		for(var i=0;i<320;i++) { 
			var intVal = parseInt(coll[i]);
			r = (intVal >> 16) & 0xff;
			g = (intVal >> 8) & 0xff;
			b = (intVal ) & 0xff;
			imageData.data[c+0]=r;
			imageData.data[c+1]=g;
			imageData.data[c+2]=b;
			imageData.data[c+3]=255;
			c+=4;
		} 

		if(c>=320*240*4) { 
			c=0;
      			gCtx.putImageData(imageData, 0,0);
		} 
 	} 

 function captureToCanvas() {
		flash = document.getElementById("embedflash");
		flash.ccCapture();
		qrcode.decode();
 }
</script>
<h4>Funding</h4>

<div class="accordion" id="accordion2">
	<div class="accordion-group">
		<div class="accordion-heading">
			<a class="accordion-toggle btn" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
				<strong><?=$t('Bitcoin Deposit / Withdrawal')?></strong> 
			</a>
		</div>
		<div id="collapseOne" class="accordion-body collapse">
			<div class="accordion-inner">
<!------------------------------------------------------------------>

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
						<form action="/users/payment/" method="post">
						<div class="input-append">
						<label for="bitcoinaddress">Bitcoin Address</label>
<input type="text" name="bitcoinaddress" id="bitcoinaddress" placeholder="15AXfnf7hshkwgzA8UKvSyjpQdtz34H9LE" class="span4" title="To Address" data-content="This is the Bitcoin Address of the recipient." value="" onblur="BitCoinAddress();"/>
					<span class="add-on"><a href="#" onclick="loadDiv();"><i class="icon-qrcode tooltip-x" rel="tooltip-x" data-placement="top" title="Scan using your webcam"></i></a></span></div>

					<small class="help-block">Enter The Bitcoin Address of the Recipient</small>

					<div id="bitcoinAddressWindow" style="display:none;border:1px solid gray;padding:2px;width:304px;text-align:center ">
					<object  id="iembedflash" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="300" height="200">
					<param name="movie" value="/js/qrcode/camcanvas.swf" />
					<param name="quality" value="high" />
					<param name="allowScriptAccess" value="always" />
					<embed  allowScriptAccess="always"  id="embedflash" src="/js/qrcode/camcanvas.swf" quality="high" width="300" height="200" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" mayscript="true"  />
					</object><br>
					<a onclick="captureToCanvas();" class="btn btn-primary">Capture</a>
					<canvas id="qr-canvas" width="300" height="200" style="display:none"></canvas>
					</div>

					<?php
					$max = (float)$details['balance.BTC'] - (float)$txfee;
					?>
							<?=$this->form->field('amount', array('label'=>'Amount', 'placeholder'=>'0.0', 'class'=>'span2', 'max'=>$max,'min'=>'0.001','onblur'=>'SuccessButtonDisable();' )); ?>
							<input type="hidden" id="maxValue" value="<?=$max?>" name="maxValue">
							<input type="hidden" id="txFee" value="<?=$txfee?>" name="txFee">							
							<div id="SendCalculations">
								<table class="table table-condensed table-bordered table-hover">
									<tr>
										<th width="30%">Send to:</th>
										<td id="SendAddress"></td>
									</tr>
									<tr>
										<th>Amount:</th>
										<td id="SendAmount"></td>
									</tr>
									<tr>
										<th>Transaction Fees:<br>
										<small>to miners</small></th>
										<td id="SendFees"></td>
									</tr>
									<tr>
										<th>Total:</th>
										<th id="SendTotal"></th>
									</tr>
								</table>
							</div>
							<input type="button" value="Calculate" class="btn btn-primary" onclick="return CheckPayment();">
							<input type="submit" value="Send" class="btn btn-success" onclick="return CheckPayment();" disabled="disabled" id="SendSuccessButton"> 
							
						</form>
					</td>
				</tr>
			</table>
		</div>
	</div>	
</div>
<!-------------------------------------------------------------------------->

			</div>
		</div>
	</div>

	<div class="accordion-group">
		<div class="accordion-heading">

			<?php 
				if($details['bank']['verified']=="Yes" && $details['utility']['verified']=="Yes" && $details['government']['verified']=="Yes" ){?>
			<span class="accordion-toggle btn" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">				
				<strong><?=$t('USD / GBP / EUR Deposits / Withdrawals')?></strong> 
			</span>
			<?php }else{?>
			<span class="accordion-toggle btn" data-toggle="collapse" data-parent="#accordion2" href="#collapseVerify">							
				<strong>Verification incomplete!</strong>
			</span>	
			<?php }?>
		</div>
		<div id="collapseVerify" class="accordion-body collapse">
			<div class="accordion-inner">
				<div class="navbar">
					<div class="navbar-inner">
						<a class="brand" href="#"><?=$t('Complete Verification')?> </a>
					</div>				
				<div class="well">
<!-----Bank Details start----->					
					<?php 
					if(strlen($details['bank.verified'])==0){
					?>
						<a href="/users/settings/bank" class="label label-warning tooltip-x" rel="tooltip-x" data-placement="top" title="Compulsary to transact!"><i class="icon-remove icon-black"></i> <?=$t("Bank Account")?></a>
					<?php }elseif($details['bank.verified']=='No'){?>
						<a href="#" class="label label-important tooltip-x" rel="tooltip-x" data-placement="top" title="Pending verification!"><i class="icon-edit icon-black"></i> <?=$t("Bank Account")?></a>
					<?php }else{ ?>
						<a href="#" class="label label-success tooltip-x" rel="tooltip-x" data-placement="top" title="Completed!"><i class="icon-ok icon-black"></i> <?=$t("Bank Account")?></a>					
					<?php }	?>
<!-----Bank Details end----->					
<!-----Government Details start----->					
					<?php 
					if(strlen($details['government.verified'])==0){
					?>
						<a href="/users/settings/government" class="label label-warning tooltip-x" rel="tooltip-x" data-placement="top" title="Compulsary to transact!"><i class="icon-remove icon-black"></i> <?=$t("Government Photo ID")?></a>
					<?php }elseif($details['government.verified']=='No'){?>
						<a href="#" class="label label-important tooltip-x" rel="tooltip-x" data-placement="top" title="Pending verification!"><i class="icon-edit icon-black"></i> <?=$t("Government Photo ID")?></a>
					<?php }else{ ?>
						<a href="#" class="label label-success tooltip-x" rel="tooltip-x" data-placement="top" title="Completed!"><i class="icon-ok icon-black"></i> <?=$t("Government ID")?></a>					
					<?php }	?>
<!-----Government Details end----->					
<!-----Utility Details start----->					
					<?php 
					if(strlen($details['utility.verified'])==0){
					?>
						<a href="/users/settings/utility" class="label label-warning tooltip-x" rel="tooltip-x" data-placement="top" title="Compulsary to transact!"><i class="icon-remove icon-black"></i> <?=$t("Proof of Address")?></a>
					<?php }elseif($details['utility.verified']=='No'){?>
						<a href="#" class="label label-important tooltip-x" rel="tooltip-x" data-placement="top" title="Pending verification!"><i class="icon-edit icon-black"></i> <?=$t("Utility Bill")?></a>
					<?php }else{ ?>
						<a href="#" class="label label-success tooltip-x" rel="tooltip-x" data-placement="top" title="Completed!"><i class="icon-ok icon-black"></i> <?=$t("Utility Bill")?></a>					
					<?php }	?>
<!-----Utility Details end----->					

					</div>
				</div>
			</div>
		</div>
		<div id="collapseTwo" class="accordion-body collapse">
			<div class="accordion-inner">
<!--------------------------------------------------------------------------->
<div class="row">
	<div class="span5">
		<div class="navbar"> 
			<form action="/users/deposit/" method="post" class="form">
			<div class="navbar-inner">
			<a class="brand" href="#"><?=$t('Deposit USD / GBP / EUR')?> </a>
			</div>
			<table class="table table-condensed table-bordered table-hover" style="margin-top:-20px">
				<tr style="background-color:#CFFDB9">
					<td colspan="2"><?=$t("Send payment to")?></td>
				</tr>
				<tr>
					<td>Sort code: </td>
					<td>08-71-99</td>
				</tr>
				<tr>
					<td>Account number:</td>
					<td>59044675</td>
				</tr>
				<tr  class=" tooltip-x" rel="tooltip-x" data-placement="top" title="Quote this reference number in your deposit">
					<td>Reference:</td>
					<?php $Reference = substr($details['username'],0,10)."-".rand(10000,99999);?>
					<td><?=$Reference?></td>
				</tr>
				<tr  class=" tooltip-x" rel="tooltip-x" data-placement="top" title="Amount should be between 1 and 10000">
					<td>Amount:</td>
					<td><input type="text" value="" class="span2" placeholder="1.0" min="1" max="10000" name="AmountFiat" id="AmountFiat" maxlength="5"></td>
				</tr>
				<tr  class=" tooltip-x" rel="tooltip-x" data-placement="top" title="Select a currency">
					<td>Currency:</td>
					<td><select name="Currency" id="Currency" class="span2">
							<option value="GBP">GBP</option>
							<option value="USD">USD</option>							
							<option value="EUR">EUR</option>							
					</select></td>
				</tr>
				<tr>
					<td colspan="2">
					<p><strong>Make SURE you deposit from your <font style="color:green">FULLY</font> Verified account. Money sent from any other account or an account <font style="color:red ">NOT FULLY</font> Verified will result in the transaction being blocked and investigated.</strong></p>
					</td>
				</tr>
				<tr  class=" tooltip-x" rel="tooltip-x" data-placement="top" title="Once your email is approved, you will receive the funds in your account in ibwt.co.uk">
					<td colspan="2" style="text-align:center ">
					<input type="hidden" name="Reference" id="Reference" value="<?=$Reference?>">
						<input type="submit" value="Send email to admin for approval" class="btn btn-primary" onclick="return CheckDeposit();">
					</td>
				</tr>
			</table>
		</div>
		</form>
	</div>
	<div class="span6">
		<div class="navbar">
			<form action="/users/withdraw/" method="post" class="form">		
			<div class="navbar-inner">
			<a class="brand" href="#"><?=$t('Withdraw USD / GBP / EUR')?> </a>
			</div>
			<table class="table table-condensed table-bordered table-hover" style="margin-top:-20px">
				<tr style="background-color:#CFFDB9">
					<td><?=$t("Balance")?></td>
					<td style="text-align:right "><?=$details['balance.USD']?> USD</td>					
					<td style="text-align:right "><?=$details['balance.GBP']?> GBP</td>
					<td style="text-align:right "><?=$details['balance.EUR']?> EUR</td>					
				</tr>			
				<tr style="background-color: #FDDBAC">
				<?php 
				$AmountGBP = 0;$AmountUSD = 0;$AmountEUR = 0;
				foreach($transactions as $transaction){
					if($transaction['Currency']=='GBP'){
						$AmountGBP = $AmountGBP + $transaction['Amount'];
					}
					if($transaction['Currency']=='EUR'){
						$AmountEUR = $AmountEUR + $transaction['Amount'];
					}					
					if($transaction['Currency']=='USD'){
						$AmountUSD = $AmountUSD + $transaction['Amount'];
					}					
				}
				?>
					<td><?=$t("Withdrawal")?></td>
					<td style="text-align:right "><?=$AmountUSD?> USD</td>					
					<td style="text-align:right "><?=$AmountGBP?> GBP</td>
					<td style="text-align:right "><?=$AmountEUR?> EUR</td>					
				</tr>			
				<tr style="background-color:#CFFDB9">
					<td><?=$t("Net Balance")?></td>
					<td style="text-align:right "><?=$details['balance.USD']-$AmountUSD?> USD</td>					
					<td style="text-align:right "><?=$details['balance.GBP']-$AmountGBP?> GBP</td>
					<td style="text-align:right "><?=$details['balance.EUR']-$AmountEUR?> EUR</td>					
				</tr>							
				<tr>
					<td colspan="2">Account name:</td>
					<td colspan="2"><input type="text" name="AccountName" id="AccountName" placeholder="Verified bank account name" value="<?=$details['bank.bankname']?>"></td>
				</tr>
				<tr>
					<td colspan="2">Sort code: </td>
					<td colspan="2"><input type="text" name="SortCode" id="SortCode" placeholder="01-01-10" value="<?=$details['bank.sortcode']?>"></td>
				</tr>
				<tr>
					<td colspan="2">Account number:</td>
					<td colspan="2"><input type="text" name="AccountNumber" id="AccountNumber" placeholder="12345678" value="<?=$details['bank.accountnumber']?>"></td>
				</tr>
				<tr  class=" tooltip-x" rel="tooltip-x" data-placement="top" title="Quote this reference number in your withdrawal">
					<td colspan="2">Reference:</td>
					<?php $Reference = substr($details['username'],0,10)."-".rand(10000,99999);?>
					<td colspan="2"><?=$Reference?></td>
				</tr>
				<tr  class=" tooltip-x" rel="tooltip-x" data-placement="top" title="Amount should be between 6 and 10000">
					<td colspan="2">Amount:</td>
					<td colspan="2"><input type="text" value="" class="span2" placeholder="6.0" min="6" max="10000" name="WithdrawAmountFiat" id="WithdrawAmountFiat" maxlength="5"><br>
<small style="color:red ">&pound;1 withdrawal fee automatically added.<br>
Minimum withdrawal &pound;5.</small></td>
				</tr>
				<tr  class=" tooltip-x" rel="tooltip-x" data-placement="top" title="Select a currency">
					<td colspan="2">Currency:</td>
					<td colspan="2"><select name="WithdrawCurrency" id="WithdrawCurrency" class="span2">
							<option value="GBP">GBP</option>
							<option value="USD">USD</option>							
							<option value="EUR">EUR</option>							
					</select></td>
				</tr>
				<tr  class=" tooltip-x" rel="tooltip-x" data-placement="top" title="Once your email is approved, you will receive the funds in your bank account">
					<td colspan="2" style="text-align:center ">
					<input type="hidden" name="WithdrawReference" id="WithdrawReference" value="<?=$Reference?>">
						<input type="submit" value="Send email to admin for approval" class="btn btn-primary" onclick="return CheckWithdrawal();">
					</td>
				</tr>
			</table>
		</div>
		</form>
	</div>
</div>
<!--------------------------------------------------------------------------->
			</div>
		</div>
	</div>
</div>
							
							
