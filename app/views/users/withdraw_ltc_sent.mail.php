<div style="background-color:#eeeeee;height:50px;padding-left:20px;padding-top:10px">
	<img src="https://<?=COMPANY_URL?>/img/<?=COMPANY_URL?>.gif" alt="<?=COMPANY_URL?>">
</div>
<h4>Hi <?=$transaction['username']?>,</h4>
<p>Your <strong><?=abs($transaction['Amount'])?> LTC</strong> is sent to <?=$transaction['address']?> from <?=COMPANY_URL?>.</p>
<p>Transaction Hash: <a href="http://blockchain.info/tx/<?=$txid?>"><?=$txid?></a></p>

<p>Thanks,<br>
<?=NOREPLY?></p>

<p>P.S. Please do not reply to this email. </p>
<p>We do not spam. </p>
