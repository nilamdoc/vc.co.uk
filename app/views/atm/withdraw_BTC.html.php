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
arr = a.split(':');
if (arr[1]==""){address=arr[0]}else{address=arr[1]}
 $("#bitcoinaddress").val(address);
 $("#SendAddress").html(address); 
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
		$("#QRCodeImage").hide();
		$("#QRCodeAddress").show();		
 }
function addAmount(val){
		$("#Amount").val($("#Amount").val()+val);
		$("#TransferAmount").val($("#TransferAmount").val()+val);		
		
}
function delAmount(){
		amount = $("#Amount").val();
		toget = amount.length-1;
		amount = amount.substr(0,toget);
		$("#Amount").val(amount);
		$("#TransferAmount").val(amount);		
}
function xTransferAmount(){
	amount = $("#Amount").val();
	$("#AmountToSendBTC").html(amount);
	$("#AmountToSend").show();
	$("#AmountToSendBTC").show();		
	$("#AmountButton").hide();
}
</script>
<div class="span10">
<h1>Withdraw</h1>
<h2><?=$t('Bitcoin balance')?>: <?=number_format($details['balance.BTC'],8)?> BTC</h2>
<h2>Scan Your Bitcoin Address</h2>
										<form action="/ATM/paymentbtc/" method="post">
<a id="QRCodeImage" href="#myModal" onclick="loadDiv();" data-toggle="modal"><img src="/img/qrcode.png" class="tooltio-x" rel="tooltip-x" data-placement="top" title="Scan using your webcam"  style="border:2px solid black "></a>
<p style="font-size:30px;display:none " id="QRCodeAddress" >Send to: <span id="SendAddress"></span></p><br>
<br>
<p style="font-size:30px;display:none;font-weight:bold " id="AmountToSend" >Amount: <span id="AmountToSendBTC"></span></p>
<br>
			<a href="#myAmountModal"  id="AmountButton"  data-toggle="modal" class="btn btn-large btn-primary">Amount</a>
											<div class="modal hide"  id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
											<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
											<h3>Scan Bitcoin Address QR code </h3>
											</div>
											<div class="modal-body" style="text-align:center ">
												<input type="text" name="bitcoinaddress" id="bitcoinaddress" placeholder="15AXfnf7hshkwgzA8UKvSyjpQdtz34H9LE" class="input-large" style="font-size:24px;height:46px;width:450px;padding:5px" title="To Address" data-content="This is the Bitcoin Address of the recipient." value="" onblur="BitCoinAddress();" />
											<div id="bitcoinAddressWindow" style="display:none;border:1px solid gray;padding:2px;width:404px;margin:auto ">
											<object  id="iembedflash" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="400" height="300">
											<param name="movie" value="/js/qrcode/camcanvas.swf" />
											<param name="quality" value="high" />
											<param name="allowScriptAccess" value="always" />
											<embed  allowScriptAccess="always"  id="embedflash" src="/js/qrcode/camcanvas.swf" quality="high" width="400" height="300" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" mayscript="true"  />
											</object><br>
											<a onclick="captureToCanvas();" class="btn btn-primary">Capture</a>
											<canvas id="qr-canvas" width="300" height="200" style="display:none"></canvas>
											</div>
										</div>
										<div class="modal-footer">
										<a href="#" class="btn" data-dismiss="modal" >Close</a>
										</div>
										</div>
										
										
<div class="modal hide"  id="myAmountModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h3 id="myModalLabel">Amount</h3>
</div>
<div class="modal-body">
			<div class="row"  style="margin:auto ">
			<div class="span7">
<?=$this->form->field('Amount', array('label'=>'', 'placeholder'=>'0.0', 'style'=>'font-size:36px;height:46px;width:250px;padding:10px;text-align:right','class'=>'input-large', 'max'=>$max,'min'=>'0.001','onFocus'=>'SuccessButtonDisable();','maxlenght'=>10)); ?>
			</div>
			</div>

		<div class="row" style="margin:auto ">
			<div class="offset2 span1">
				<input type="button" value="1" class="btn btn-primary span1" style="font-size:24px" onclick="addAmount('1')">
			</div>
			<div class="span1">
				<input type="button" value="2" class="btn btn-primary span1" style="font-size:24px " onclick="addAmount('2')">
			</div>
			<div class="span1">
				<input type="button" value="3" class="btn btn-primary span1" style="font-size:24px " onclick="addAmount('3')">
			</div>		
		</div>
		<div class="row">
			<div class="span5">&nbsp;</div>
		</div>
		<div class="row" style="margin:auto ">
			<div class="span1 offset2">
				<input type="button" value="4" class="btn btn-primary span1" style="font-size:24px " onclick="addAmount('4')">
			</div>
			<div class="span1">
				<input type="button" value="5" class="btn btn-primary span1" style="font-size:24px " onclick="addAmount('5')">
			</div>
			<div class="span1">
				<input type="button" value="6" class="btn btn-primary span1" style="font-size:24px " onclick="addAmount('6')">
			</div>		
		</div>
		<div class="row" style="margin:auto ">
			<div class="span3">&nbsp;</div>
		</div>
		<div class="row" style="margin:auto ">
			<div class="span1 offset2">
				<input type="button" value="7" class="btn btn-primary span1" style="font-size:24px " onclick="addAmount('7')">
			</div>
			<div class="span1">
				<input type="button" value="8" class="btn btn-primary span1" style="font-size:24px " onclick="addAmount('8')">
			</div>
			<div class="span1">
				<input type="button" value="9" class="btn btn-primary span1" style="font-size:24px " onclick="addAmount('9')">
			</div>		
		</div>
		<div class="row" style="margin:auto ">
			<div class="span3">&nbsp;</div>
		</div>
		<div class="row" style="margin:auto ">
			<div class="span1 offset2">
				<input type="button" value="." class="btn btn-primary span1" style="font-size:24px " onclick="addAmount('.')">
			</div>
			<div class="span1">
				<input type="button" value="0" class="btn btn-primary span1" style="font-size:24px " onclick="addAmount('0')">
			</div>
			<div class="span1">
				<input type="button" value="Del" class="btn btn-primary span1" style="font-size:24px " onclick="delAmount()" >
			</div>		
		</div>
		<div class="row">
			<div class="span3">&nbsp;</div>
		</div>

</div>
<div class="modal-footer">
<button class="btn btn-primary" data-dismiss="modal" aria-hidden="true" onClick="xTransferAmount();">Save</button>
</div>
</div>
									<?php
									$max = (float)$details['balance.BTC'];
									?>
											<input type="hidden" id="maxValue" value="<?=$max?>" name="maxValue">
											<input type="hidden" id="txFee" value="<?=$txfee?>" name="txFee">							
											<input type="hidden" id="TransferAmount" value="0" name="TransferAmount" onFocus="SuccessButtonDisable()">														<br>
											<div id="SendCalculations"><br><br>
					<p style="font-size:30px;"  >Total Amount: <span id="SendAmount"></span></p><br>
					<p style="font-size:30px;"  >Fees <small>to miners</small>: <span id="SendFees"></span></p>					<br>
					<p style="font-size:30px;"  >You Receive: <span id="SendTotal"></span></p>					<br>
											</div>
											<input type="button" value="Calculate" class="btn btn-primary btn-large" onclick="return CheckPayment();">
											<input type="submit" value="Send" class="btn btn-success btn-large" onclick="return CheckPayment();" disabled="disabled" id="SendSuccessButton"> 
			<a href="/ATM/dashboard" class="btn btn-success btn-large">Dashboard</a>											
			<a href="/ATM/index" class="btn btn-danger btn-large">Logout</a>											
										</form>
</div>