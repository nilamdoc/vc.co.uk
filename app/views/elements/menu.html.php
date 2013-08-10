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
	<li <?php if($sel_curr==""){echo "class='active'";}?>>
		<a href="/<?=$locale?>/ex/dashboard/"><?=$t('Dashboard')?></a>
	</li>
	<?php foreach($trades as $t){?>
		<li <?php if($sel_curr==strtolower(str_replace("/","_",$t['trade']))){echo "class='active'";}?>>
		<a href="/<?=$locale?>/ex/x/<?=strtolower(str_replace("/","_",$t['trade']))?>"><?=$t['trade']?></a></li>
	<?php }	?>
</ul>
