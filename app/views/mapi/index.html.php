<section id="MAPI">
	<div class="page-header">
		<h1>Merchant API Documentation</h1>
	</div>
<h4>"In Bitcoin We Trust" supports Merchant API</h4>
		<?php 
		if(strlen($details['key'])>0){
		$key = $details['key'];
		}else{
		$key = "YOUR_API_KEY";
		}
		?>

	<h5>Checkout Buttons</h5>
	<ul>
		<li><strong>BTC</strong></li>
		<li><strong>LTC</strong></li>
	</ul>
	<h4 id="headings">Simple BTC Checkout Button</h4>
			<p id="headings">All payments received through this checkout button will be credited to you ibwt.co.uk account</p>
		<div class="bs-docs-example">
		If you have signed in as a user you should be able to see the URL with your own API key. <br>
		URL: https://ibwt.co.uk/MAPI/BTC/<?=$key?>
		<h5>Parameters:</h5>
		<table class="table table-condensed table-bordered table-hover" style="width:50% ">
			<tr>
				<th>Parameter</th>
				<th>Required</th>
				<th>Description</th>
				<th>Default</th>
			</tr>
			<tr>
				<td>invoice</td>
				<td>no</td>
				<td>Invoice number to verify with your accounts.</td>
				<td>None</td>
			</tr>
		</table>
		<?php if(strlen($details['key'])>0){?>
		<div class="bs-docs-tryit">
		<h4>Get only JSON</h4>
		<form action="/MAPI/BTC/<?=$key?>" method="post" target="_blank">
		<table class="table table-condensed " style="width:50% ">
			<tr>
				<td>Invoice:</td>
				<td><input type="text" name="invoice" id="invoice" class="span2"></td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" value="Get Address JSON" class="btn btn-primary"></td>
			</tr>
		</table>
		</form>
		</div>
		<div class="bs-docs-tryit">
		<h4>JSON example to get the Bitcoin Address and QR Image</h4>
			<table class="table table-condensed " style="width:50% ">
				<tr>
					<td>Invoice:</td>
					<td><input type="text" name="invoice_t" id="invoice_t" class="span2" value=""></td>
				</tr>
				<tr>
					<td colspan="2"><a href="#" onclick="GetJSONIBWT();"><img src="/img/ibwt.co.uk-checkout.png" border="0"></a></td>
				</tr>
			</table>
			<div id="ibwtBTC">
				<div>Send Bitcoin payment to: 
				<div id="ibwtBTCAddress"></div>
				</div>
				<div id="ibwtBTCImage"></div>
			</div>
		<pre  class=" linenums"><?='
<input type="text" name="invoice_t" id="invoice_t" class="span2" value="">

<a href="#" onclick="GetJSONIBWT();"><img src="/img/ibwt.co.uk-checkout.png" border="0"></a>

<div id="ibwtBTC">
 <div>Send Bitcoin payment to: 
  <div id="ibwtBTCAddress"></div>
 </div>
 <div id="ibwtBTCImage"></div>
</div>

<script>
function GetJSONIBWT(){
var invoice = document.getElementById("invoice_t").value;
$.getJSON("http://ibwt.co.uk/MAPI/BTC/'.$key.'?invoice="+invoice,
 function(ReturnValues){
 document.getElementById("ibwtBTCAddress").innerHTML = ReturnValues["result"]["address"];
 document.getElementById("ibwtBTCImage").innerHTML = "<img src=\'"+ReturnValues["result"]["QRimage"]+"\' border="1">";			
 });
}
</script>'?>
</pre>
		</div>
		<?php }?>
	</div>
	<h4 id="headings">BTC Checkout Button with success / cancel URL</h4>
			<p id="headings">All payments received through this checkout button will be credited to you ibwt.co.uk account</p>
		<div class="bs-docs-example">
		New Example
		</div>	
</section>
<script>
function GetJSONIBWT(){
	var	invoice = document.getElementById("invoice_t").value;
		$.getJSON('/MAPI/BTC/<?=$key?>?invoice='+invoice,
		function(ReturnValues){
			document.getElementById('ibwtBTCAddress').innerHTML = ReturnValues['result']['address'];
			document.getElementById('ibwtBTCImage').innerHTML = "<img src='"+ReturnValues['result']['QRimage']+"'>";			
		});
}
</script>