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
 				<p><a href="https://ibwt.co.uk/api/tradesdate/2013-10-10" target="_blank">https://ibwt.co.uk/api/tradesdate/YYYY-MM-DD</a> This API will output all data for 10th October 2013.</p>
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
		URL: <a href="https://ibwt.co.uk/API/Info/<?=$key?>" target="_blank">https://ibwt.co.uk/API/Info/<?=$key?></a>
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
		URL: <a href="https://ibwt.co.uk/API/Transactionhistory/<?=$key?>" target="_blank">https://ibwt.co.uk/API/Transactionhistory/<?=$key?></a>
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

}</pre>
		</div>
		<section>			

		TransHistory
		
		It returns the transactions history.
		
		Parameters:
		parameter 	oblig? 	description 	it takes on the values 	standard value
		from 	No 	The ID of the transaction to start displaying with 	numerical 	0
		count 	No 	The number of transactions for displaying 	numerical 	1,000
		from_id 	No 	The ID of the transaction to start displaying with 	numerical 	0
		end_id 	No 	The ID of the transaction to finish displaying with 	numerical 	8
		order 	No 	sorting 	ASC or DESC 	DESC
		since 	No 	When to start displaying? 	UNIX time 	0
		end 	No 	When to finish displaying? 	UNIX time 	8
		
		Note: while using since or end parameters, the order parameter automatically take up ASC value.
		
		The example of an answer:
		
		{
			"success":1,
			"return":{
				"1081672":{
					"type":1,
					"amount":1.00000000,
					"currency":"BTC",
					"desc":"BTC Payment",
					"status":2,
					"timestamp":1342448420
				}
			}
		}
			
		
		TradeHistory
		
		It returns the trade history
		
		Parameters:
		parameter 	????? 	description 	It takes up the value 	standard value
		from 	No 	the number of the transaction to start displaying with 	numerical 	0
		count 	No 	the number of transactions for displaying 	numerical 	1000
		from_id 	No 	the ID of the transaction to start displaying with 	numerical 	0
		end_id 	No 	the ID of the transaction to finish displaying with 	numerical 	8
		order 	No 	sorting 	ASC or DESC 	DESC
		since 	No 	when to start the displaying 	UNIX time 	0
		end 	No 	when to finish the displaying 	UNIX time 	8
		pair 	No 	the pair to show the transactions 	btc_usd (example) 	all pairs
		
		Note: while using since or end parameters, order parameter automatically takes up ASC value.
		
		The example of an answer:
		
		{
			"success":1,
			"return":{
				"166830":{
					"pair":"btc_usd",
					"type":"sell",
					"amount":1,
					"rate":1,
					"order_id":343148,
					"is_your_order":1,
					"timestamp":1342445793
				}
			}
		}
			
		
		OrderList
		
		It returns your open orders/the orders history.
		
		Parameters:
		parameter 	oblig? 	description 	it takes up values 	standard value
		from 	No 	the number of the order to start displaying with 	numerical 	0
		count 	No 	The number of orders for displaying 	numerical 	1000
		from_id 	No 	id of the order to start displaying with 	numerical 	0
		end_id 	No 	id of the order to finish displaying 	numerical 	8
		order 	No 	sorting 	ASC or DESC 	DESC
		since 	No 	when to start displaying 	UNIX time 	0
		end 	No 	when to finish displaying 	UNIX time 	8
		pair 	No 	the pair to display the orders 	btc_usd (example) 	all pairs
		active 	No 	is it displaying of active orders only? 	1 or 0 	1
		
		Note: while using since or end parameters, order parameter automatically takes up ASC value.
		
		The example of an answer
		
		{
			"success":1,
			"return":{
				"343152":{
					"pair":"btc_usd",
					"type":"sell",
					"amount":1.00000000,
					"rate":3.00000000,
					"timestamp_created":1342448420,
					"status":0
				}
			}
		}
			
		
		Trade
		
		Trading is done according to this method.
		
		Parameters:
		parameter 	oblig? 	description 	it takes up the values 	standard value
		pair 	Yes 	pair 	btc_usd (example) 	-
		type 	Yes 	The transaction type 	buy or sell 	-
		rate 	Yes 	The rate to buy/sell 	numerical 	-
		amount 	Yes 	The amount which is necessary to buy/sell 	numerical 	-
		
		The example of an asnwer:
		
		{
			"success":1,
			"return":{
				"received":0.1,
				"remains":0,
				"order_id":0,
				"funds":{
					"usd":325,
					"btc":2.498,
					"sc":121.998,
					"ltc":0,
					"ruc":0,
					"nmc":0
				}
			}
		}
			
		
		CancelOrder
		
		Cancellation of the order
		
		Parameters:
		parameter 	oblig? 	description 	it takes up the values 	standard value
		order_id 	Yes 	Order id 	numerical 	-
		
		The example of an answer:
		
		{
			"success":1,
			"return":{
				"order_id":343154,
				"funds":{
					"usd":325,
					"btc":24.998,
					"sc":121.998,
					"ltc":0,
					"ruc":0,
					"nmc":0
				}
			}
		}
