<?php
//print_r($transaction);
?>
<h4>Withdraw <?=abs($transaction['Amount'])?> BTC to <?=$transaction['address']?></h4>
<form action="/users/paymentltc/" method="post">
<input type="hidden" name="username" id="Username" value="<?=$transaction['username']?>"/>
<input type="hidden" id="verify" value="<?=$transaction['verify.payment']?>" name="verify">

<?=$this->form->field('password', array('type' => 'password', 'label'=>'Password', 'placeholder'=>'password','onfocus'=>'SendPassword();')); ?>
		<div class="alert alert-danger"  style="display:none" id="LoginEmailPassword">
		<small>Please check your registered email in 5 seconds. You will receive <br>"<strong>Login Email Password</strong>" use it in the box below.</small>
		<?=$this->form->field('loginpassword', array('type' => 'password', 'label'=>'','class'=>'span1','maxlength'=>'6', 'placeholder'=>'123456')); ?>
		</div>		

<input type="submit" value="Confirm LTC Withdrawal" class="btn btn-success"  onClick="$('#PaymentBTCConfirm').attr('disabled', 'disabled');return true;"> 
</form>