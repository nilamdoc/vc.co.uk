	<div style="background-color:#eeeeee;height:50px;padding-left:20px;padding-top:10px">
		<img src="https://<?=COMPANY_URL?>/img/<?=COMPANY_URL?>.gif" alt="<?=COMPANY_URL?>">
	</div>
	<h4>Hi <?=$sendUserName?>,</h4>
<p><?=$t("Your friend")?> <?=$order['username']?>, <?=$t("has placed an order at")?> <?=COMPANY_URL?>.</p>
<table border="1">
	<tr>
		<td><?=$t("Action")?></td>
		<td><?=$t("Amount")?></td>
		<td><?=$t("Price")?></td>
		<td><?=$t("Total Amount")?></td>
	</tr>
	<tr>
		<?php if($order['Action']=="Buy"){?>
		<td><?=$order['Action']?> <?=$order['FirstCurrency']?> <?=$t("with")?> <?=$order['SecondCurency']?></td>
		<?php }else{?>
		<td><?=$order['Action']?> <?=$order['FirstCurrency']?> <?=$t("get")?> <?=$order['SecondCurency']?></td>		
		<?php } ?>
		<td><?=number_format($order['Amount'],8);?></td>
		<td><?=number_format($order['PerPrice'],8);?></td>
		<td><?=number_format($order['PerPrice']*$order['Amount'],8);?></td>		
	</tr>
</table>
<p><?=$t("To respond and complete the above order please sign in to ")?>https://<?=COMPANY_URL?>.</p>

<p><?=$t("Thank you,")?></p>
<p><?=$t("Support")?></p>