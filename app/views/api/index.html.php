		<section id="API">
			<div class="page-header">
				<h1>API Documentation</h1>
			</div>
		<h4>"<strong>In Bitcoin We Trust</strong>" supports two API's</h4>
		<ol>
			<li><strong>Public access</strong>
				<ul>
					<li>Trades</li>
					<li>TradesDate</li>
				</ul>
			</li>
			<li><strong>User Authenticated</strong>
				<ul>
					<li>Info</li>
					<li>TransactionHistory</li>
					<li>OrderHistory</li>
					<li>OrderList</li>
					<li>Trade</li>			
					<li>CancelOrder</li>			
				</ul>
			</li>
		</ol>
		</section>
		<section id="Trades">
			<div class="page-header">
				<h1>Trades</h1>
			</div>
			<h4 id="headings">List recent trades in each currency</h4>
			<div class="bs-docs-example">
				<p><a href="https://ibwt.co.uk/API/trades" target="_blank">https://ibwt.co.uk/API/trades</a></p>
				<pre>
{
	"success":1,
	"now":"1380617132",
	"result":[
		{"Low":"90.00","High":"99.00","Last":"95.00","FirstUnit":"BTC","SecondUnit":"USD"},
		{"Low":"85.00","High":"89.00","Last":"88.00","FirstUnit":"BTC","SecondUnit":"GBP"},
		{"Low":"102.00","High":"105.00","Last":"103.00","FirstUnit":"BTC","SecondUnit":"EUR"}
	]
}</pre>
			</div>
		</section>
		<section id="TradesDate">
			<div class="page-header">
				<h1>TradesDate</h1>
			</div>
			<h4 id="headings">List recent trades in each currency for a specific date</h4>
			<p id="headings">If no date is specified, the result will include orders for today. The result includes all currencies, buy and sell, completed and pending.</p>
			<div class="bs-docs-example">
				<p><a href="https://ibwt.co.uk/API/tradesdate/" target="_blank">https://ibwt.co.uk/API/tradesdate/</a> This API function will output all orders for today.</p>
				<p><strong>Passing date in YYYY-MM-DD to the API will output data for that date.</strong></p>
 				<p><a href="https://ibwt.co.uk/API/tradesdate/2013-10-02" target="_blank">https://ibwt.co.uk/API/tradesdate/YYYY-MM-DD</a> This API will output all data for 2nd October 2013.</p>
				<pre>
{
	"success":1,
	"now":1380585600,
	"result":[
		{"DateTime":1380606864,"Action":"Sell","FromCurrency":"BTC","ToCurrency":"EUR","BTC":20,"PerPrice":150,"Completed":"N"},
		{"DateTime":1380606850,"Action":"Sell","FromCurrency":"BTC","ToCurrency":"EUR","BTC":10,"PerPrice":100,"Completed":"N"},
		{"DateTime":1380605936,"Action":"Sell","FromCurrency":"BTC","ToCurrency":"USD","BTC":11,"PerPrice":91,"Completed":"N"},
		{"DateTime":1380605925,"Action":"Buy","FromCurrency":"BTC","ToCurrency":"USD","BTC":4,"PerPrice":90,"Completed":"N"},
		{"DateTime":1380605922,"Action":"Buy","FromCurrency":"BTC","ToCurrency":"USD","BTC":6,"PerPrice":90,"Completed":"Y"}
	]
}</pre>
			</div>
		</section>


		
		<h5>Authentication</h5>
		<p>Authorization is performed by sending the following HTTP Headers:<br>
		<ul>
		<li>Key &mdash; API key. The example of API key: <strong>FLDGNIMJVNRMB3MXPF2EVH2VKAYY7DUBA43YZF7RVQ4MMHAHABAUK7JJZSJG3PXE</strong></li>
		<li>POST &mdash; POST data (?key=val&amp;param1=val1)</li>
		</ul>
		You can find your API Key in Settings / Security tab.

		<p>All request are sent to https://ibwt.co.uk/API/<strong>FunctionName</strong></p>
		<pre>All requests must also include a special <strong>nonce</strong> POST parameter with increment integer. (>0)
The URL should include the key as a parameter.
All other parameters should be submitted by POST method.
All server answers are in JSON format.
		</pre>
		If the completion is successful, there is an answer like:
		<pre>{"success":1,"return":{&lt;return&gt;}}</pre>
		The answer in case of an error:
		<pre>{"success":0,"error":"&lt;error text&gt;"}</pre>
	<!--
		<div class="bs-docs-example">
		PHP: http://pastebin.com/QyjS3U9M
		
		Python: http://pastebin.com/ec11hxcP by miraclemax
		
		Python: https://github.com/alanmcintyre/btce-API by alanmcintyre
		
		Java: http://pastebin.com/jyd9tACF by dApZoKntut
		
		C#: https://github.com/DmT021/BtceAPI by DmT
		
		C++/CLI: http://pastebin.com/YvxmCRL9 by PoorGirl
		
		VB.NET: http://pastebin.com/JmJZSsd7 by franky1
		
		Objective-C: https://github.com/backmeupplz/BTCEBot by backmeupplz
		
		Ruby: https://github.com/cgore/ruby-btce by cgore & teddythetwig
		</div>		
		-->
		<h3>The list of methods: User Authentication required</h3>
		<section id="Info">
			<div class="page-header">
				<h1>Info</h1>
			</div>
			<h4 id="headings">List user information</h4>
			<p id="headings">It returns the information about the user's current balance, API key privileges,the number of transactions, the number of open orders and the server time.</p>
		<div class="bs-docs-example">
		If you have signed in as a user you should be able to see the URL with your own API key. <br>
		<?php 
		if(strlen($details['key'])>0){
		$key = $details['key'];
		}else{
		$key = "YOUR_API_KEY";
		}
		?>
		URL: https://ibwt.co.uk/API/Info/<?=$key?>
		<h5>Parameters:</h5>
		<p>nounce: integer &gt; 0</p>
		<?php 
		if(strlen($details['key'])>0){?>
		<div class="bs-docs-tryit">
		<form action="/API/Info/<?=$key?>" method="post" target="_blank">
			<input type="hidden" name="nounce" value="<?=time()?>">
			<input type="submit" value="Info" class="btn btn-primary">
		</form>
		<h5>Code:</h5>
		<pre>
&lt;form action="/API/Info/<?=$key?>" method="post" target="_blank"&gt;
	&lt;input type="hidden" name="nounce" value="<?=time()?>"&gt;
	&lt;input type="submit" value="Info" class="btn btn-primary"&gt;
&lt;/form&gt;
		</pre>
		</div>
		<?php }else{?>
		<div class="bs-docs-tryit">		
		<p>Please sign in to check the code with an example.</p>
<h5>Code:</h5>
		<pre>
&lt;form action="/API/Info/<?=$key?>" method="post" target="_blank"&gt;
	&lt;input type="hidden" name="nounce" value="<?=time()?>"&gt;
	&lt;input type="submit" value="Info" class="btn btn-primary"&gt;
&lt;/form&gt;
		</pre>		
		</div>
		<?php }?>
		<h5>Expected Result:</h5>
		<pre>
{"success":1,
"now":1380701646,
"result":{
"TOTP":{"Validate":true,"Login":true,"Withdrawal":true,"Security":true},
"balance":{"BTC":5.856,"USD":1114.208,"GBP":458.23,"EUR":987.34},
"government":{"name":"Passport.jpg","verified":"Yes"},
"addressproof":{"name":"UtilityBill.jpg","verified":"Yes"},
"bank":{"name":"Nothern Bank","address":"Lanchaiser","account":"John Abraham","number":"12345678","sortcode":"12-34-5678","verified":"Yes"},
"email":{"address":"John@MyEmailAddress.com","verified":"Yes"},
"user":{"first_name":"John","last_name":"Abraham","username":"JohnA342","created":1377849940},
"orders":{"pending":4,"complete":12,"sell":8,"buy":4},
"transactions":{"BTC":10,"Other":12}
}
}</pre>
		</div>
		<section>			
		

		<section id="TransactionHistory">
			<div class="page-header">
				<h1>TransactionHistory</h1>
			</div>
			<h4 id="headings"></h4>
			<p id="headings">It returns the transactions history.</p>
		<div class="bs-docs-example">
		If you have signed in as a user you should be able to see the URL with your own API key. <br>
		<?php 
		if(strlen($details['key'])>0){
		$key = $details['key'];
		}else{
		$key = "YOUR_API_KEY";
		}
		?>
		URL: https://ibwt.co.uk/API/Transactionhistory/<?=$key?>
		<h5>Parameters:</h5>
		<table class="table table-condensed table-bordered table-hover" style="width:50% ">
			<tr>
				<th>Parameter</th>
				<th>Required</th>
				<th>Description</th>
				<th>Default</th>
			</tr>
			<tr>
				<td>nounce</td>
				<td>yes</td>
				<td>integer > 0</td>
				<td>1</td>
			</tr>
			<tr>
				<td>count</td>
				<td>no</td>
				<td>number of records to fetch from the system</td>
				<td>1000</td>
			</tr>
			<tr>
				<td>order</td>
				<td>no</td>
				<td>ASC or DESC on DateTime</td>
				<td>DESC</td>
			</tr>
			<tr>
				<td>start</td>
				<td>no</td>
				<td>Starting date for the transactions in YYYY-MM-DD</td>
				<td>2013-10-01</td>
			</tr>
			<tr>
				<td>end</td>
				<td>no</td>
				<td>Ending date for the transactions in YYYY-MM-DD</td>
				<td><?=gmdate('Y-m-d',time())?></td>
			</tr>	
			<tr>
				<td>type</td>
				<td>no</td>
				<td>All / Deposit / Withdrawal</td>
				<td>All</td>
			</tr>					
			<tr>
				<td>currency</td>
				<td>no</td>
				<td>All / BTC / Other / USD / GBP / EUR</td>
				<td>All</td>
			</tr>								
		</table>
		<?php 
		if(strlen($details['key'])>0){?>
		<div class="bs-docs-tryit">
		<form action="/API/Transactionhistory/<?=$key?>" method="post" target="_blank">
			<input type="hidden" name="nounce" value="<?=time()?>">
		<table class="table table-condensed " style="width:50% ">
			<tr>
				<td>Count:</td>
				<td><input type="text" name="count" value="1000" class="span2"></td>
			</tr>
			<tr>
				<td>Order:</td>
				<td><select name="order" class="span2">
				<option value="DESC">DESC</option>
				<option value="ASC">ASC</option>
			</select></td>
			</tr>
			<tr>
				<td>Start:</td>
				<td><input type="text" name="start" value="2013-10-01" class="span2"></td>
			</tr>
			<tr>
				<td>End:</td>
				<td><input type="text" name="end" value="<?=gmdate('Y-m-d',time())?>" class="span2"></td>
			</tr>
			<tr>
				<td>Type:</td>
				<td><select name="type" class="span2">
				<option value="All">All</option>
				<option value="Deposit">Deposit</option>
				<option value="Withdrawal">Withdrawal</option>								
			</select></td>
			</tr>
			<tr>
				<td>Currency:</td>
				<td><select name="currency" class="span2">
				<option value="All">All</option>
				<option value="BTC">BTC</option>
				<option value="Other">Other, not BTC</option>				
				<option value="USD">USD</option>				
				<option value="GBP">GBP</option>				
				<option value="EUR">EUR</option>				
			</select></td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" value="Transaction History" class="btn btn-primary"></td>
			</tr>
		</table>
		</form>
		<h5>Code:</h5>
		<pre>
<?='<form action="/API/Transactionhistory/'.$key.'" method="post" target="_blank">
<input type="hidden" name="nounce" value="'.time().'">
Count: <input type="text" name="count" value="1000" class="span2">
Order: <select name="order" class="span2">
	<option value="DESC">DESC</option>
	<option value="ASC">ASC</option>
</select>
Start: <input type="text" name="start" value="2013-10-01" class="span2">
End: <input type="text" name="end" value="'.gmdate('Y-m-d',time()).'" class="span2">
Type: <select name="type" class="span2">
	<option value="All">All</option>
	<option value="Deposit">Deposit</option>
	<option value="Withdrawal">Withdrawal</option>								
</select>
Currency: <select name="currency" class="span2">
	<option value="All">All</option>
	<option value="BTC">BTC</option>
	<option value="Other">Other, not BTC</option>				
	<option value="USD">USD</option>				
	<option value="GBP">GBP</option>				
	<option value="EUR">EUR</option>				
</select>
<input type="submit" value="Transaction History" class="btn btn-primary">
</form>'?>
		</pre>
		</div>
		<?php }else{?>
		<div class="bs-docs-tryit">		
		<p>Please sign in to check the code with an example.</p>
<h5>Code:</h5>
		<pre><?='<form action="/API/Transactionhistory/'.$key.'" method="post" target="_blank">
<input type="hidden" name="nounce" value="'.time().'">
Count: <input type="text" name="count" value="1000" class="span2">
Order: <select name="order" class="span2">
	<option value="DESC">DESC</option>
	<option value="ASC">ASC</option>
</select>
Start: <input type="text" name="start" value="2013-10-01" class="span2">
End: <input type="text" name="end" value="'.gmdate('Y-m-d',time()).'" class="span2">
Type: <select name="type" class="span2">
	<option value="All">All</option>
	<option value="Deposit">Deposit</option>
	<option value="Withdrawal">Withdrawal</option>								
</select>
Currency: <select name="currency" class="span2">
	<option value="All">All</option>
	<option value="BTC">BTC</option>
	<option value="Other">Other, not BTC</option>				
	<option value="USD">USD</option>				
	<option value="GBP">GBP</option>				
	<option value="EUR">EUR</option>				
</select>
<input type="submit" value="Transaction History" class="btn btn-primary">
</form>'?></pre>		
		</div>
		<?php }?>
		<h5>Expected Result:</h5>
		<pre>{"success":1,
"now":1380783508,
"result":[
{"DateTime":1379650918,"Amount":0.05,"Currency":"BTC","Type":"Deposit","TransactionHash":"6e56defc13c783b39a1c878880b9a3c498e67039c5a7d6670d658e53bc12b04a","Address":"1NcBBigUFRNCqG2qvvbMm4Wb2ourKW4iQA"},
{"DateTime":1380695609,"Amount":10,"Currency":"GBP","Type":"Deposit","Approved":"No","Reference":"JohnAbraham-67367"},
{"DateTime":1380191863,"Amount":0.3,"Currency":"BTC","Type":"Deposit","TransactionHash":"9647bb757ce7a73a6a4f7dc10495b9c96805279b876bf8ba428c82799c9445a5","Address":"1NwhgWHbiaXqYiE4GPc1rxQJaaiu7cxcXD"},
{"DateTime":1380705506,"Amount":50,"Currency":"GBP","Type":"Deposit","Approved":"Yes","Reference":"JohnAbraham-15444","AmountApproved":50},
{"DateTime":1380563790,"Amount":1,"Currency":"GBP","Type":"Deposit","Approved":"Rejected","Reference":"JohnAbraham-71853","Reason":"Funds not received"},
{"DateTime":1380729195,"Amount":-0.09869,"Currency":"BTC","Type":"Withdrawal","TransactionHash":"ec2a0f3604ad157695c7e7427806036af1d8b612b0027c7c171f2824a846b1fb","Address":"1G91BB3FrgMVChETXH6DfcU9CDimr6F4eM","txFee":-0.0005,"Transfer":"Sent 0.09869 BTC to 1G91BB3FrgMVChETXH6DfcU9CDimr6F4eM"}
]}</pre>
		</div>
		<section>			

<section id="OrderHistory">
			<div class="page-header">
				<h1>OrderHistory</h1>
			</div>
			<h4 id="headings"></h4>
			<p id="headings">It returns the orders history.</p>
		<div class="bs-docs-example">
		If you have signed in as a user you should be able to see the URL with your own API key. <br>
		<?php 
		if(strlen($details['key'])>0){
		$key = $details['key'];
		}else{
		$key = "YOUR_API_KEY";
		}
		?>
		URL: https://ibwt.co.uk/API/Orderhistory/<?=$key?>
		<h5>Parameters:</h5>
		<table class="table table-condensed table-bordered table-hover" style="width:50% ">
			<tr>
				<th>Parameter</th>
				<th>Required</th>
				<th>Description</th>
				<th>Default</th>
			</tr>
			<tr>
				<td>nounce</td>
				<td>yes</td>
				<td>integer > 0</td>
				<td>1</td>
			</tr>
			<tr>
				<td>count</td>
				<td>no</td>
				<td>number of records to fetch from the system</td>
				<td>1000</td>
			</tr>
			<tr>
				<td>order</td>
				<td>no</td>
				<td>ASC or DESC on DateTime</td>
				<td>DESC</td>
			</tr>
			<tr>
				<td>start</td>
				<td>no</td>
				<td>Starting date for the transactions in YYYY-MM-DD</td>
				<td>2013-10-01</td>
			</tr>
			<tr>
				<td>end</td>
				<td>no</td>
				<td>Ending date for the transactions in YYYY-MM-DD</td>
				<td><?=gmdate('Y-m-d',time())?></td>
			</tr>	
			<tr>
				<td>type</td>
				<td>no</td>
				<td>All / Buy / Sell</td>
				<td>All</td>
			</tr>					
			<tr>
				<td>Status</td>
				<td>no</td>
				<td>All / Complete / Pending</td>
				<td>All</td>
			</tr>								
		</table>
		<?php 
		if(strlen($details['key'])>0){?>
		<div class="bs-docs-tryit">
		<form action="/API/Orderhistory/<?=$key?>" method="post" target="_blank">
			<input type="hidden" name="nounce" value="<?=time()?>">
		<table class="table table-condensed " style="width:50% ">
			<tr>
				<td>Count:</td>
				<td><input type="text" name="count" value="1000" class="span2"></td>
			</tr>
			<tr>
				<td>Order:</td>
				<td><select name="order" class="span2">
				<option value="DESC">DESC</option>
				<option value="ASC">ASC</option>
			</select></td>
			</tr>
			<tr>
				<td>Start:</td>
				<td><input type="text" name="start" value="2013-10-01" class="span2"></td>
			</tr>
			<tr>
				<td>End:</td>
				<td><input type="text" name="end" value="<?=gmdate('Y-m-d',time())?>" class="span2"></td>
			</tr>
			<tr>
				<td>Type:</td>
				<td><select name="type" class="span2">
				<option value="All">All</option>
				<option value="Buy">Buy</option>
				<option value="Sell">Sell</option>								
			</select></td>
			</tr>
			<tr>
				<td>Status:</td>
				<td><select name="status" class="span2">
				<option value="All">All</option>
				<option value="Complete">Complete</option>
				<option value="Pending">Pending</option>				
			</select></td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" value="Orders History" class="btn btn-primary"></td>
			</tr>
		</table>
		</form>
		<h5>Code:</h5>
		<pre>
<?='<form action="/API/Orderhistory/'.$key.'" method="post" target="_blank">
<input type="hidden" name="nounce" value="'.time().'">
Count: <input type="text" name="count" value="1000" class="span2">
Order: <select name="order" class="span2">
	<option value="DESC">DESC</option>
	<option value="ASC">ASC</option>
</select>
Start: <input type="text" name="start" value="2013-10-01" class="span2">
End: <input type="text" name="end" value="'.gmdate('Y-m-d',time()).'" class="span2">
Type: <select name="type" class="span2">
	<option value="All">All</option>
	<option value="Buy">Buy</option>
	<option value="Sell">Sell</option>								
</select>
Currency: <select name="status" class="span2">
	<option value="All">All</option>
	<option value="Complete">Complete</option>
	<option value="Pending">Pending</option>				
</select>
<input type="submit" value="Orders History" class="btn btn-primary">
</form>'?>
		</pre>
		</div>
		<?php }else{?>
		<div class="bs-docs-tryit">		
		<p>Please sign in to check the code with an example.</p>
<h5>Code:</h5>
		<pre>
<?='<form action="/API/Orderhistory/'.$key.'" method="post" target="_blank">
<input type="hidden" name="nounce" value="'.time().'">
Count: <input type="text" name="count" value="1000" class="span2">
Order: <select name="order" class="span2">
	<option value="DESC">DESC</option>
	<option value="ASC">ASC</option>
</select>
Start: <input type="text" name="start" value="2013-10-01" class="span2">
End: <input type="text" name="end" value="'.gmdate('Y-m-d',time()).'" class="span2">
Type: <select name="type" class="span2">
	<option value="All">All</option>
	<option value="Buy">Buy</option>
	<option value="Sell">Sell</option>								
</select>
Currency: <select name="status" class="span2">
	<option value="All">All</option>
	<option value="Complete">Complete</option>
	<option value="Pending">Pending</option>				
</select>
<input type="submit" value="Orders History" class="btn btn-primary">
</form>'?>

		</pre>		
		</div>
		<?php }?>
		<h5>Expected Result:</h5>
		<pre>{"success":1,
"now":1380796105,
"result":[
{"DateTime":1380523982,"type":"Buy","pair":"BTC_USD","CommissionAmount":0.032,"CommissionCurrency":"BTC","Amount":4,"Price":90,"TotalAmount":360,"status":"Y","order_id":"52491fce9d5d0c6c0c000040"},
{"DateTime":1380605922,"type":"Buy","pair":"BTC_USD","CommissionAmount":0.048,"CommissionCurrency":"BTC","Amount":6,"Price":90,"TotalAmount":540,"status":"Y","order_id":"52491fce9d5d0c6c0c000050"},
{"DateTime":1380605925,"type":"Buy","pair":"BTC_USD","CommissionAmount":0.032,"CommissionCurrency":"BTC","Amount":4,"Price":90,"TotalAmount":360,"status":"N","order_id":"52491fce9d5d0c6c0c000440"},
{"DateTime":1380605936,"type":"Sell","pair":"BTC_USD","CommissionAmount":8.008,"CommissionCurrency":"USD","Amount":11,"Price":91,"TotalAmount":1001,"status":"N","order_id":"52491fce9d5d0c6c0c006040"},
{"DateTime":1380606850,"type":"Sell","pair":"BTC_EUR","CommissionAmount":8,"CommissionCurrency":"EUR","Amount":10,"Price":100,"TotalAmount":1000,"status":"N","order_id":"52491fce9d5d0c6c0c080040"},
{"DateTime":1380606864,"type":"Sell","pair":"BTC_EUR","CommissionAmount":24,"CommissionCurrency":"EUR","Amount":20,"Price":150,"TotalAmount":3000,"status":"N","order_id":"52491fce9d5d0c6c0c000090"}
]}</pre>
		</div>
		<section>			
<section id="OrderList">
			<div class="page-header">
				<h1>OrderList</h1>
			</div>
			<h4 id="headings"></h4>
			<p id="headings">It returns the open orders list .</p>
		<div class="bs-docs-example">
		If you have signed in as a user you should be able to see the URL with your own API key. <br>
		<?php 
		if(strlen($details['key'])>0){
		$key = $details['key'];
		}else{
		$key = "YOUR_API_KEY";
		}
		?>
		URL: https://ibwt.co.uk/API/Orderlist/<?=$key?>
		<h5>Parameters:</h5>
		<table class="table table-condensed table-bordered table-hover" style="width:50% ">
			<tr>
				<th>Parameter</th>
				<th>Required</th>
				<th>Description</th>
				<th>Default</th>
			</tr>
			<tr>
				<td>nounce</td>
				<td>yes</td>
				<td>integer > 0</td>
				<td>1</td>
			</tr>
			<tr>
				<td>count</td>
				<td>no</td>
				<td>number of records to fetch from the system</td>
				<td>1000</td>
			</tr>
			<tr>
				<td>order</td>
				<td>no</td>
				<td>ASC or DESC on DateTime</td>
				<td>DESC</td>
			</tr>
			<tr>
				<td>start</td>
				<td>no</td>
				<td>Starting date for the transactions in YYYY-MM-DD</td>
				<td>2013-10-01</td>
			</tr>
			<tr>
				<td>end</td>
				<td>no</td>
				<td>Ending date for the transactions in YYYY-MM-DD</td>
				<td><?=gmdate('Y-m-d',time())?></td>
			</tr>	
			<tr>
				<td>type</td>
				<td>no</td>
				<td>All / Buy / Sell</td>
				<td>All</td>
			</tr>
			<tr>
				<td>pair</td>
				<td>no</td>
				<td>All / BTC_USD / BTC_GBP / BTC_EUR</td>
				<td>All</td>
			</tr>			
		</table>
		<?php 
		if(strlen($details['key'])>0){?>
		<div class="bs-docs-tryit">
		<form action="/API/Orderlist/<?=$key?>" method="post" target="_blank">
			<input type="hidden" name="nounce" value="<?=time()?>">
		<table class="table table-condensed " style="width:50% ">
			<tr>
				<td>Count:</td>
				<td><input type="text" name="count" value="1000" class="span2"></td>
			</tr>
			<tr>
				<td>Order:</td>
				<td><select name="order" class="span2">
				<option value="DESC">DESC</option>
				<option value="ASC">ASC</option>
			</select></td>
			</tr>
			<tr>
				<td>Start:</td>
				<td><input type="text" name="start" value="2013-10-01" class="span2"></td>
			</tr>
			<tr>
				<td>End:</td>
				<td><input type="text" name="end" value="<?=gmdate('Y-m-d',time())?>" class="span2"></td>
			</tr>
			<tr>
				<td>Type:</td>
				<td><select name="type" class="span2">
				<option value="All">All</option>
				<option value="Buy">Buy</option>
				<option value="Sell">Sell</option>								
			</select></td>
			</tr>
			<tr>
				<td>Pair:</td>
				<td><select name="pair" class="span2">
				<option value="All">All</option>
				<option value="BTC_USD">BTC_USD</option>
				<option value="BTC_GBP">BTC_GBP</option>
				<option value="BTC_EUR">BTC_EUR</option>
			</select></td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" value="Order List" class="btn btn-primary"></td>
			</tr>
		</table>
		</form>
		<h5>Code:</h5>
		<pre>
<?='<form action="/API/Orderlist/'.$key.'" method="post" target="_blank">
<input type="hidden" name="nounce" value="'.time().'">
Count: <input type="text" name="count" value="1000" class="span2">
Order: <select name="order" class="span2">
	<option value="DESC">DESC</option>
	<option value="ASC">ASC</option>
</select>
Start: <input type="text" name="start" value="2013-10-01" class="span2">
End: <input type="text" name="end" value="'.gmdate('Y-m-d',time()).'" class="span2">
Type: <select name="type" class="span2">
	<option value="All">All</option>
	<option value="Buy">Buy</option>
	<option value="Sell">Sell</option>								
</select>
Pair: <select name="pair" class="span2">
	<option value="All">All</option>
	<option value="BTC_USD">BTC_USD</option>
	<option value="BTC_GBP">BTC_GBP</option>
	<option value="BTC_EUR">BTC_EUR</option>
</select>
<input type="submit" value="Order List" class="btn btn-primary">
</form>'?>
		</pre>
		</div>
		<?php }else{?>
		<div class="bs-docs-tryit">		
		<p>Please sign in to check the code with an example.</p>
<h5>Code:</h5>
		<pre>
<?='<form action="/API/Orderhistory/'.$key.'" method="post" target="_blank">
<input type="hidden" name="nounce" value="'.time().'">
Count: <input type="text" name="count" value="1000" class="span2">
Order: <select name="order" class="span2">
	<option value="DESC">DESC</option>
	<option value="ASC">ASC</option>
</select>
Start: <input type="text" name="start" value="2013-10-01" class="span2">
End: <input type="text" name="end" value="'.gmdate('Y-m-d',time()).'" class="span2">
Type: <select name="type" class="span2">
	<option value="All">All</option>
	<option value="Buy">Buy</option>
	<option value="Sell">Sell</option>								
</select>
Pair: <select name="pair" class="span2">
	<option value="All">All</option>
	<option value="BTC_USD">BTC_USD</option>
	<option value="BTC_GBP">BTC_GBP</option>
	<option value="BTC_EUR">BTC_EUR</option>
</select>
<input type="submit" value="Order List" class="btn btn-primary">
</form>'?>

		</pre>		
		</div>
		<?php }?>
		<h5>Expected Result:</h5>
		<pre>{"success":1,
"now":1380798462,
"result":[
{"DateTime":1380605925,"type":"Buy","pair":"BTC_USD","CommissionAmount":0.032,"CommissionCurrency":"BTC","Amount":4,"Price":90,"TotalAmount":360,"status":"N","order_id":"524a5fe59d5d0cb80b000001"},
{"DateTime":1380605936,"type":"Sell","pair":"BTC_USD","CommissionAmount":8.008,"CommissionCurrency":"USD","Amount":11,"Price":91,"TotalAmount":1001,"status":"N","order_id":"524a5ff09d5d0cd00c000000"},
{"DateTime":1380606850,"type":"Sell","pair":"BTC_EUR","CommissionAmount":8,"CommissionCurrency":"EUR","Amount":10,"Price":100,"TotalAmount":1000,"status":"N","order_id":"524a63829d5d0cb80b000002"},
{"DateTime":1380606864,"type":"Sell","pair":"BTC_EUR","CommissionAmount":24,"CommissionCurrency":"EUR","Amount":20,"Price":150,"TotalAmount":3000,"status":"N","order_id":"524a63909d5d0cb80b000003"}
]}</pre>
		</div>
		<section>			


		<section>			
<section id="Trade">
			<div class="page-header">
				<h1>Trade</h1>
			</div>
			<h4 id="headings"></h4>
			<p id="headings">It submits an order in the selected currency pair.</p>
		<div class="bs-docs-example">
		If you have signed in as a user you should be able to see the URL with your own API key. <br>
		<?php 
		if(strlen($details['key'])>0){
		$key = $details['key'];
		}else{
		$key = "YOUR_API_KEY";
		}
		?>
		URL: https://ibwt.co.uk/API/Trade/<?=$key?>
		<h5>Parameters:</h5>
		<table class="table table-condensed table-bordered table-hover" style="width:50% ">
			<tr>
				<th>Parameter</th>
				<th>Required</th>
				<th>Description</th>
				<th>Default</th>
			</tr>
			<tr>
				<td>nounce</td>
				<td>yes</td>
				<td>integer > 0</td>
				<td>1</td>
			</tr>
			<tr>
			<tr>
				<td>type</td>
				<td>yes</td>
				<td>Buy / Sell</td>
				<td>Buy</td>
			</tr>
			<tr>
				<td>pair</td>
				<td>yes</td>
				<td>BTC_USD / BTC_GBP / BTC_EUR</td>
				<td>BTC_GBP</td>
			</tr>			
			<tr>
				<td>amount</td>
				<td>yes</td>
				<td>amount of BTC > 0</td>
				<td>1.0</td>
			</tr>			
			<tr>
				<td>price</td>
				<td>yes</td>
				<td>price per BTC > 0</td>
				<td>null</td>
			</tr>						
		</table>
		<?php 
		if(strlen($details['key'])>0){?>
		<div class="bs-docs-tryit">
		<form action="/API/Trade/<?=$key?>" method="post" target="_blank">
			<input type="hidden" name="nounce" value="<?=time()?>">
		<table class="table table-condensed " style="width:50% ">
			<tr>
				<td>Type:</td>
				<td><select name="type" class="span2">
				<option value="Buy">Buy</option>
				<option value="Sell">Sell</option>								
			</select></td>
			</tr>
			<tr>
				<td>Pair:</td>
				<td><select name="pair" class="span2">
				<option value="BTC_USD">BTC_USD</option>
				<option value="BTC_GBP" selected="selected">BTC_GBP</option>
				<option value="BTC_EUR">BTC_EUR</option>
			</select></td>
			</tr>
			<tr>
				<td>Amount:</td>
				<td><input type="text" value="" placeholder="1.0" min="0.000001" max="9999" name="amount" id="amountBTC" class="span2"></td>
			</tr>
			<tr>
				<td>Price:</td>
				<td><input type="text" value="" placeholder="100.0" min="1" max="99999" name="price" id="PerPriceBTC" class="span2"></td>
			</tr>			
			<tr>
				<td colspan="2"><input type="submit" value="Trade" class="btn btn-primary"></td>
			</tr>
		</table>
		</form>
		<h5>Code:</h5>
		<pre>
<?='<form action="/API/Trade/'.$key.'" method="post" target="_blank">
<input type="hidden" name="nounce" value="'.time().'">
Type: <select name="type" class="span2">
<option value="Buy">Buy</option>
<option value="Sell">Sell</option>								
</select>
Pair: <select name="pair" class="span2">
<option value="BTC_USD">BTC_USD</option>
<option value="BTC_GBP" selected="selected">BTC_GBP</option>
<option value="BTC_EUR">BTC_EUR</option>
</select>
Amount: <input type="text" value="" placeholder="1.0" min="0.000001" max="9999" name="amount" id="amountBTC" class="span2">
Price: <input type="text" value="" placeholder="100.0" min="1" max="99999" name="price" id="PerPriceBTC" class="span2">
<input type="submit" value="Trade" class="btn btn-primary">
</form>'?>
		</pre>
		</div>
		<?php }else{?>
		<div class="bs-docs-tryit">		
		<p>Please sign in to check the code with an example.</p>
<h5>Code:</h5>
		<pre>
<?=''?></pre>		
		</div>
		<?php }?>
		<h5>Expected Result:</h5>
		<pre>{"success":1,
"now":1381215939,
"result":
{
	"Order_id":"5253aec39d5d0c1c0c000009",
	"pair":"BTC_GBP",
	"type":"Buy",
	"Commission.Amount":0.008,
	"Commission.Currency":"BTC",
	"amount":1,
	"price":100,
	"time":1381215939,
	"Completed":"N",
	"username":"JohnAbraham"
}}</pre>		</div>
		<section>			


<section id="CancelOrder">
			<div class="page-header">
				<h1>Cancelorder</h1>
			</div>
			<h4 id="headings"></h4>
			<p id="headings">It will cancel an order placed with the order_id</p>
		<div class="bs-docs-example">
		If you have signed in as a user you should be able to see the URL with your own API key. <br>
		<?php 
		if(strlen($details['key'])>0){
		$key = $details['key'];
		}else{
		$key = "YOUR_API_KEY";
		}
		?>
		URL: https://ibwt.co.uk/API/cancelorder/<?=$key?>
		<h5>Parameters:</h5>
		<table class="table table-condensed table-bordered table-hover" style="width:50% ">
			<tr>
				<th>Parameter</th>
				<th>Required</th>
				<th>Description</th>
				<th>Default</th>
			</tr>
			<tr>
				<td>nounce</td>
				<td>yes</td>
				<td>integer > 0</td>
				<td>1</td>
			</tr>
			<tr>
			<tr>
				<td>order_id</td>
				<td>yes</td>
				<td>The Order_id generated with the Trade API</td>
				<td>null</td>
			</tr>
		</table>
		<?php 
		if(strlen($details['key'])>0){?>
		<div class="bs-docs-tryit">
		<form action="/API/cancelorder/<?=$key?>" method="post" target="_blank">
			<input type="hidden" name="nounce" value="<?=time()?>">
		<table class="table table-condensed " style="width:50% ">
			<tr>
				<td>Order_id:</td>
				<td><input type="text" value="<?=(string)$order['_id']?>" name="order_id" id="order_id" class="span4"></td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" value="Cancel order" class="btn btn-primary"></td>
			</tr>
		</table>
		</form>
		<h5>Code:</h5>
		<pre>
<?='<form action="/API/cancelorder/'.$key.'" method="post" target="_blank">
<input type="hidden" name="nounce" value="'.time().'">
<input type="text" value="" name="order_id" id="order_id" class="span4">
<input type="submit" value="Cancel order" class="btn btn-primary">
</form>'?>
		</pre>
		</div>
		<?php }else{?>
		<div class="bs-docs-tryit">		
		<p>Please sign in to check the code with an example.</p>
<h5>Code:</h5>
		<pre>
<?='<form action="/API/cancelorder/'.$key.'" method="post" target="_blank">
<input type="hidden" name="nounce" value="'.time().'">
<input type="text" value="" name="order_id" id="order_id" class="span4">
<input type="submit" value="Cancel order" class="btn btn-primary">
</form>'?></pre>		
		</div>
		<?php }?>
		<h5>Expected Result:</h5>
		<pre>{"success":1,"now":1381218058,"result":true}</pre>		
	</div>
<section>			


