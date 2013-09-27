<div>
<h4>API Description</h4>
<h5>Authentication</h5>
<p>Authorization is performed by sending the following HTTP Headers:<br>
<ul>
<li>Key &mdash; API key. The example of API key: <strong>FLDGNIMJVNRMB3MXPF2EVH2VKAYY7DUBA43YZF7RVQ4MMHAHABAUK7JJZSJG3PXE</strong></li>
<li>Sign &mdash; POST data (?param=val&amp;param1=val1)</li>
</ul>
You can find your API Key in Settings / Security tab.
</p>
<pre>All request are sent to https://ibwt.co.uk/api/<strong>FunctionName</strong></pre>

All requests must also include a special nonce POST parameter with increment integer. (>0)

The method name is sent via POST parameter method.

All the method parameters are sent via POST.

All server answers are in JSON format.

If the completion is successful, there is an answer like:
<pre>
{"success":1,"return":{&lt;return&gt;}}
</pre>
The answer in case of an error:

{"success":0,"error":"<error text>"}


Examples:

PHP: http://pastebin.com/QyjS3U9M

Python: http://pastebin.com/ec11hxcP by miraclemax

Python: https://github.com/alanmcintyre/btce-api by alanmcintyre

Java: http://pastebin.com/jyd9tACF by dApZoKntut

C#: https://github.com/DmT021/BtceApi by DmT

C++/CLI: http://pastebin.com/YvxmCRL9 by PoorGirl

VB.NET: http://pastebin.com/JmJZSsd7 by franky1

Objective-C: https://github.com/backmeupplz/BTCEBot by backmeupplz

Ruby: https://github.com/cgore/ruby-btce by cgore & teddythetwig

The list of methods
getInfo

It returns the information about the user's current balance, API key privileges,the number of transactions, the number of open orders and the server time.

Parameters:

None.

The example of an answer:

{
	"success":1,
		"return":{
		"funds":{
			"usd":325,
			"btc":23.998,
			"sc":121.998,
			"ltc":0,
			"ruc":0,
			"nmc":0
		},
		"rights":{
			"info":1,
			"trade":1
		},
		"transaction_count":80,
		"open_orders":1,
		"server_time":1342123547
	}
}
	

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
	


</div>
