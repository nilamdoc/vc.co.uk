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
						<label for="bitcoinaddress">Bitcoin Address</label>
<input type="text" name="bitcoinaddress" id="bitcoinaddress" placeholder="15AXfnf7hshkwgzA8UKvSyjpQdtz34H9LE" class="span4" title="To Address" data-content="This is the Bitcoin Address of the recipient." value="" />
					<span class="add-on"><a href="#" onclick="loadDiv();"><i class="icon-qrcode"></i></a></span></div>
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
							<?=$this->form->field('amount', array('label'=>'Amount', 'placeholder'=>'0.0', 'class'=>'span2')); ?>
						</form>
					</td>
				</tr>
			</table>
		</div>
	</div>	
</div>
