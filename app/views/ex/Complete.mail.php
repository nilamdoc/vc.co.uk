<div style="background-color:#eeeeee;height:50px;padding-left:20px;padding-top:10px">
	<img src="https://<?=COMPANY_URL?>/img/<?=COMPANY_URL?>.gif" alt="<?=COMPANY_URL?>">
</div>
<h4>Hi <?=$user['username']?>,</h4>	
<p><?=$t("Your order is complete, processed and fully executed at ")?><?=COMPANY_URL?>.</p>
<table border="1">
	<tr>
		<td><?=$t("OrderDate")?></td>	
		<td><?=$t("Action")?></td>
		<td><?=$t("Amount")?></td>
		<td><?=$t("Price")?></td>
		<td><?=$t("Total Amount")?></td>
	</tr>
	<tr>
		<td><?=date('Y-M-d H:i:s',$order['DateTime']->sec)?></td>
		<?php if($order['Action']=="Buy"){?>
		<td><?=$order['Action']?> <?=$order['FirstCurrency']?> with <?=$order['SecondCurrency']?></td>
		<?php }else{?>
		<td><?=$order['Action']?> <?=$order['FirstCurrency']?> get <?=$order['SecondCurrency']?></td>		
		<?php } ?>
		<td><?=number_format($order['Amount'],8);?> <?=$order['FirstCurrency']?></td>
		<td><?=number_format($order['PerPrice'],8);?></td>
		<td><?=number_format($order['PerPrice']*$order['Amount'],8);?> <?=$order['SecondCurrency']?></td>		
	</tr>
	<tr>
		<td colspan="2"><?=$t("Commission")?></td>
		<td colspan="2"><?=number_format($order['Commission.Amount'],8)?></td>
		<td><?=$order['Commission.Currency']?></td>
	</tr>
	<tr>
		<td colspan="2"><?=$t("Transact Date")?></td>
		<td colspan="3"><?=date('Y-M-d H:i:s',$order['Transact.DateTime']->sec)?></td>
	</tr>
</table>

<p><?=$t("To check order please sign in to ")?>https://<?=COMPANY_URL?>.</p>

<p><?=$t("Thank you,")?></p>
<p><?=$t("Support")?></p>