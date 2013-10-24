<div class="well" style="background-image:url(/img/Stamp.png);background-position:bottom right;background-repeat:no-repeat;min-height:600px">
<h4>Users: <?=$TotalUsers?></h4>
<form action="/Admin/user" method="post">
<input type="text" class="span1" value="<?=$pagelength?>" name="pagelength" id="pagelenght">
<input type="submit" value="Get report" class="btn btn-primary">
</form>
<?php print_r($page_links);?>
<table class="table table-condensed table-bordered table-hover" style="font-size:12px ">
	<thead>
		<tr>
			<th>Username</th>
			<th>Full Name</th>			
			<th>Email</th>						
			<th>BTC</th>			
			<th>LTC</th>						
			<th>USD</th>															
			<th>GBP</th>												
			<th>EUR</th>						
			<th>Sign in</th>
			<th>IP</th>
		</tr>
	</thead>
	<tbody>
<?php 
print_r($Details);
foreach ($Details as $user){ ?>
	<tr>
		<td><a href="/Admin/detail/<?=$user['username']?>"><?=$user['username']?></a></td>
		<td><?=$user['firstname']?> <?=$user['lastname']?></td>		
		<td><?=$user['email']?></td>				
		<td style="text-align:right "><?=number_format($user['BTC'],8)?><br>
		Orders: <?=number_format($user['Sell']['BTC-USD']['Amount']+$user['Sell']['BTC-GBP']['Amount']+$user['Sell']['BTC-EUR']['Amount']+$user['Sell']['BTC-LTC']['Amount'],8)?><br>
		<strong>Total: <?=number_format($user['BTC']+$user['Sell']['BTC-USD']['Amount']+$user['Sell']['BTC-GBP']['Amount']+$user['Sell']['BTC-EUR']['Amount']+$user['Sell']['BTC-LTC']['Amount'],8)?></strong>
		</td>				
		<td style="text-align:right "><?=number_format($user['LTC'],8)?><br>
		Orders: <?=number_format($user['Sell']['LTC-USD']['Amount']+$user['Sell']['LTC-GBP']['Amount']+$user['Sell']['LTC-EUR']['Amount']+$user['Buy']['BTC-LTC']['TotalAmount'],8)?><br>
		<strong>Total: <?=number_format($user['LTC']+$user['Sell']['LTC-USD']['Amount']+$user['Sell']['LTC-GBP']['Amount']+$user['Sell']['LTC-EUR']['Amount']+$user['Buy']['BTC-LTC']['TotalAmount'],8)?></strong>
		</td>				
		<td style="text-align:right "><?=number_format($user['USD'],4)?><br>
		Orders: <?=number_format($user['Buy']['BTC-USD']['TotalAmount'],4)?><br>
		<strong>Total: <?=number_format($user['USD']+$user['Buy']['BTC-USD']['TotalAmount'],4)?></strong>
		</td>				
		<td style="text-align:right "><?=number_format($user['GBP'],4)?><br>
		Orders: <?=number_format($user['Buy']['BTC-GBP']['TotalAmount'],4)?><br>
		<strong>Total: <?=number_format($user['GBP']+$user['Buy']['BTC-GBP']['TotalAmount'],4)?></strong>
		</td>				
		<td style="text-align:right "><?=number_format($user['EUR'],4)?><br>
		Orders: <?=number_format($user['Buy']['BTC-EUR']['TotalAmount'],4)?><br>
		<strong>Total: <?=number_format($user['EUR']+$user['Buy']['BTC-EUR']['TotalAmount'],4)?></strong>
		</td>				
		<td><?=gmdate('Y-M-d H:i:s',$user['created']->sec)?></td>
		<td><?=$user['ip']?></td>
	</tr>
<?php 
	$TotalBTC = $TotalBTC + $user['BTC']+$user['Sell']['BTC-USD']['Amount']+$user['Sell']['BTC-GBP']['Amount']+$user['Sell']['BTC-EUR']['Amount']+$user['Sell']['BTC-LTC']['Amount'];
	$TotalLTC = $TotalLTC + $user['LTC']+$user['Sell']['LTC-USD']['Amount']+$user['Sell']['LTC-GBP']['Amount']+$user['Sell']['LTC-EUR']['Amount']+$user['Buy']['BTC-LTC']['TotalAmount'];
	$TotalUSD = $TotalUSD + $user['USD']+$user['Buy']['BTC-USD']['TotalAmount'];
	$TotalGBP = $TotalGBP + $user['GBP']+$user['Buy']['BTC-GBP']['TotalAmount'];
	$TotalEUR = $TotalEUR + $user['EUR']+$user['Buy']['BTC-EUR']['TotalAmount'];		
} ?>
	<tr>
		<td colspan="3"><strong>Total</strong></td>
		<td style="text-align:right "><strong><?=number_format($TotalBTC,8)?></strong></td>
		<td style="text-align:right "><strong><?=number_format($TotalLTC,8)?></strong></td>		
		<td style="text-align:right "><strong><?=number_format($TotalUSD,4)?></strong></td>
		<td style="text-align:right "><strong><?=number_format($TotalGBP,4)?></strong></td>
		<td style="text-align:right "><strong><?=number_format($TotalEUR,4)?></strong></td>						
		<td colspan="2"></td>
	</tr>
</tbody>
</table>
<?php print_r($page_links);?>
</div>