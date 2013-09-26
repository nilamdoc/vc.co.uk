<?php use lithium\core\Environment; 
if(substr(Environment::get('locale'),0,2)=="en"){$locale = "en";}else{$locale = Environment::get('locale');}
?>
<?php
use app\models\Trades;
$trades = Trades::find('all');
$sel_curr = $this->_request->params['args'][0];
?>
<h4><?php if($sel_curr==""){echo $t('Dashboard');}else{echo strtoupper(str_replace("_","/",$sel_curr));}?></h4>
<ul class="nav nav-tabs push-right">
	<?php if(!stristr($_SERVER['REQUEST_URI'],"Admin")){	?>
	<li <?php if($sel_curr==""){echo "class='active'";}?>>
		<a href="/<?=$locale?>/ex/dashboard/"><?=$t('Dashboard')?></a>
	</li>
		<?php foreach($trades as $tr){?>
			<li <?php if($sel_curr==strtolower(str_replace("/","_",$tr['trade']))){echo "class='active'";}?>>
			<a href="/<?=$locale?>/ex/x/<?=strtolower(str_replace("/","_",$tr['trade']))?>"><?=$tr['trade']?></a></li>
		<?php }	?>
	<?php }else{?>
		<li><a href="/Admin/index" ><?=$t("Summary")?></a></li>
		<li><a href="/Admin/commission" ><?=$t("Commission")?></a></li>		
		<li><a href="/Admin/approval"><?=$t("Approval")?></a></li>		
		<li><a href="/Admin/bitcoin"><?=$t("Bitcoin")?></a></li>				
		<li><a href="/Admin/transactions"><?=$t("Deposits")?></a></li>				
		<li><a href="/Admin/withdrawals"><?=$t("Withdrawals")?></a></li>						
		<li><a href="/Admin/user"><?=$t("User")?></a></li>								
	<?php }	?>	
</ul>
