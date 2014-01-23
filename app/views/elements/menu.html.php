<?php use lithium\core\Environment; 
if(substr(Environment::get('locale'),0,2)=="en"){$locale = "en";}else{$locale = Environment::get('locale');}
?>
<?php
use app\models\Trades;
$trades = Trades::find('all');
$sel_curr = $this->_request->params['args'][0];
if($this->_request->params['controller']!='api'){
?>
<h4><?php if($sel_curr==""){echo $t('Dashboard');}else{echo strtoupper(str_replace("_","/",$sel_curr));}?></h4>
<ul class="nav nav-tabs push-right">
	<?php if(!stristr($_SERVER['REQUEST_URI'],"Admin")){	?>
	<li <?php if($sel_curr==""){echo "class='active'";}?>>
		<a href="/<?=$locale?>/ex/dashboard/" style="cursor:pointer "><img src="/img/dashboard.png" alt="Dashboard"></a>
	</li>
		<?php foreach($trades as $tr){?>
			<li <?php if($sel_curr==strtolower(str_replace("/","_",$tr['trade']))){echo "class='active'";}?>>
			<a href="/<?=$locale?>/ex/x/<?=strtolower(str_replace("/","_",$tr['trade']))?>" class="tooltip-x" rel="tooltip-x" data-placement="top" title="<?=$tr['trade']?>">
			<img src="/img/<?=$tr['First']?>.png">&raquo;<img src="/img/<?=$tr['Second']?>.png">
			</a></li>
		<?php }	?>
<li><a href="https://www.okpay.com/?rbp=IBWT" target="_blank" class="tooltip-x" rel="tooltip-x" data-placement="top" title="Sign up for OKPAY and start accepting payments instantly.">
<img src="/img/OkPay-Banner-small.png">
</a></li>
	<?php }else{?>
		<li><a href="/Admin/index" ><?=$t("Summary")?></a></li>
		<li><a href="/Admin/commission" ><?=$t("Comm")?></a></li>		
		<li><a href="/Admin/approval"><?=$t("Approval")?></a></li>		
<!--		<li><a href="/Admin/bitcoin"><?=$t("Bitcoin")?></a></li>				-->
		<li><a href="/Admin/transactions"><?=$t("Deposits")?></a></li>				
		<li><a href="/Admin/withdrawals"><?=$t("Withdrawals")?></a></li>						
		<li><a href="/Admin/user"><?=$t("User")?></a></li>								
		<li><a href="/Admin/bitcointransaction"><?=$t("BTC")?></a></li>										
		<li><a href="/Admin/litecointransaction"><?=$t("LTC")?></a></li>												
		<li><a href="/Admin/orders"><?=$t("Orders")?></a></li>												
		<li><a href="/Admin/api"><?=$t("API")?></a></li>														
		<li><a href="/Admin/down" class="tooltip-x"  rel="tooltip-x" data-placement="top" title="Danger! All users will be logged out and not able to sign in too... You will have to call Nilam to start it!"><i class="icon-off"></i></a></li>																
	<?php }	?>	
</ul>
<?php }	?>	