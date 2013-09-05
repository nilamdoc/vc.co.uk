<?php
use app\extensions\action\Functions;
			$function = new Functions();
?><div>
<strong>Network status: V<?=$getinfo['version']/10000?></strong> We are in sync with bitcoin network using <a href="/network/peer"><strong><?=$getconnectioncount?></strong></a> connections!
<hr>
<h2><a href="/network/blocks"><?=$getblockcount?> Blocks</a></h2>
Generated <?=$function->toFriendlyTime((time()-$getblock['time']));?> mins ago at <?=gmdate('Y-m-d H:i:s',$getblock['time'])?>. 
The above block had difficulty level of <?=$getblock['difficulty']?>.<br>
Hash: <code><?=$getblock['hash']?></code>

</div>