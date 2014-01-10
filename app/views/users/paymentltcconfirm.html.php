<h4>Withdraw <?=abs($transaction['Amount'])?> LTC to <?=$transaction['address']?></h4>
<form action="/users/paymentltc/" method="post">
<input type="hidden" name="username" id="Username" value="<?=$transaction['username']?>"/>
<input type="hidden" id="verify" value="<?=$transaction['verify.payment']?>" name="verify">
<?=$this->form->field('password', array('type' => 'password', 'label'=>'Password', 'placeholder'=>'password')); ?>
<input type="submit" value="Confirm LTC Withdrawal" class="btn btn-success" id="PaymentLTCConfirm" onClick="$('#PaymentLTCConfirm').attr('disabled', 'disabled');return true;"> 
</form>