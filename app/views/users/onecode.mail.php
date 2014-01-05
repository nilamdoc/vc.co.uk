<?php
			$response = file_get_contents("http://ipinfo.io/{$_SERVER['REMOTE_ADDR']}");
			$details = json_decode($response);
			if($details->tor) {
				$tor = "Login is disabled from TOR!"
			}
?>
<p>Use this "<strong>Login Email Password</strong>" to sign in to <?=$COMPANY_URL?></p>
<p>
Login: <?=$username?><br>
Login Email Password: <strong style="font-size:24px;font-weight:bold "><?=$oneCode?></strong><br>
IP: <?=$_SERVER['REMOTE_ADDR'];?><br>
<?=$tor?>
Date and time: <?=gmdate('Y-m-d H:i:s',time())?>
</p>