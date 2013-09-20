<h4>User</h4>
<table class="table table-condensed table-bordered table-hover" >
	<thead>
		<tr>
			<th>Username</th>
			<th>Full Name</th>			
			<th>Sign in</th>
			<th>IP</th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($users['dataset'] as $user){ ?>
	<tr>
		<td><a href="/Admin/detail/<?=$user['username']?>"><?=$user['username']?></a></td>
		<td><?=$user['firstname']?> <?=$user['lastname']?></td>		
		<td><?=gmdate('Y-M-d H:i:s',$user['created']->sec)?></td>
		<td><?=$user['ip']?></td>
	</tr>
<?php } ?>
</tbody>
</table>
<?php print_r($page_links);?>