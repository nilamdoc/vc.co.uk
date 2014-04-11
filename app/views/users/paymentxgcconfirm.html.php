<h4>Withdraw <?=abs($transaction['Amount'])?> XGC to <?=$transaction['address']?></h4>
<form action="/users/paymentxgc/" method="post"  id="PaymentForm">
<input type="hidden" name="username" id="Username" value="<?=$transaction['username']?>"/>
<input type="hidden" id="verify" value="<?=$transaction['verify.payment']?>" name="verify">
<?=$this->form->field('password', array('type' => 'password', 'label'=>'Password', 'placeholder'=>'password')); ?>
<input type="submit" value="Confirm XGC Withdrawal" class="btn btn-success" id="PaymentXGCConfirm" onClick="document.getElementById('PaymentXGCConfirm').disabled = true;$('#PaymentForm').submit();"> 
</form>