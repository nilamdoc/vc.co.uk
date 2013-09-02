<?php
use app\extensions\action\Functions;
$function = new Functions();
?><h2>Details of last 10 blocks generated.</h2>
<table class="table table-condensed table-striped table-bordered" style="background-color:white ">
	<thead>
		<tr>
			<th>Block Hash</th>
			<th>Height</th>			
			<th>Num Tx</th>			
			<th>Time</th>			
			<th></th>						
		</tr>
	</thead>
<tbody>
<?php foreach($getblock as $block){?>
	<tr>
		<td><code><a href="/network/blockhash/<?=$block['hash'];?>"><?=$block['hash'];?></a></code></td>
		<td><?=$block['height'];?></td>		
		<td><?=count($block['tx']);?></td>
		<td><?=date('Y-m-d H:i:s',$block['time']);?></td>		
		<td><?=$function->toFriendlyTime((time()-$block['time']));?></td>				
	</tr>
<?php }?>
	<tr>
		<td colspan="2"><a href="/network/blocks" class="pull-left btn">Latest</a></td>
		<td colspan="3">
		<a href="/network/blocks/<?=($block['height']+19)?>" class="pull-right btn">Next >> 10</a>
		<a href="/network/blocks/<?=$block['height']-1?>" class="pull-right btn">Previous << 10</a>
		</td>		
	</tr>
</tbody>
</table>
