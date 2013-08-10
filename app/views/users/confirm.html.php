<?php
?>
<h4>Your email is verified!</h4>
<p>Thank you for verifying your email address. We will also be verifying your mobile number.</p>
<h5>You can skip this verification and directly login to the site!</h5>
<a href="/login" class="btn btn-primary">Login</a>
<?=$this->form->create("",array('url'=>'/users/mobile/')); ?>
<?=$this->form->field('mobile.number', array('label'=>'Mobile','placeholder'=>'+911112223333' )); ?>
<?=$this->form->field('user_id', array('type'=>'hidden','value'=>$id )); ?>
<?=$this->form->submit('Send SMS',array('class'=>'btn btn-primary')); ?>
<?=$this->form->end(); ?>

We will send you an SMS to the number you provide, please confirm the same number on the next screen.