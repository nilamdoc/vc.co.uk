<h4>Users: <?=$TotalUsers?></h4>
<?php print_r($page_links);?>
<table class="table table-condensed table-bordered table-hover" >
	<thead>
		<tr>
			<th>Username</th>
			<th>Full Name</th>			
			<th>Email</th>						
			<th>BTC</th>			
			<th>USD</th>															
			<th>GBP</th>												
			<th>EUR</th>						
			<th>Sign in</th>
			<th>IP</th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($Details as $user){ ?>
	<tr>
		<td><a href="/Admin/detail/<?=$user['username']?>"><?=$user['username']?></a></td>
		<td><?=$user['firstname']?> <?=$user['lastname']?></td>		
		<td><?=$user['email']?></td>				
		<td><?=number_format($user['BTC'],8)?></td>				
		<td><?=number_format($user['USD'],2)?></td>				
		<td><?=number_format($user['GBP'],2)?></td>				
		<td><?=number_format($user['EUR'],2)?></td>				
		<td><?=gmdate('Y-M-d H:i:s',$user['created']->sec)?></td>
		<td><?=$user['ip']?></td>
	</tr>
<?php } ?>
</tbody>
</table>
<?php print_r($page_links);?>