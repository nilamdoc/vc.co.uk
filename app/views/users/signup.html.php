<h2>Sign up</h2>
<div class="row">
	<div class="span4">
<?=$this->form->create($user); ?>
<?php if($refer!=""){?>
<?=$this->form->field('refer', array('label'=>'Refered by bitcoin address','value'=>$refer,'readonly'=>'readonly','class'=>'span4' )); ?>
<?php }else{?>
<?=$this->form->field('refer', array('type'=>'hidden','value'=>'')); ?>
<?php }?>
<?=$this->form->field('firstname', array('label'=>'First Name','placeholder'=>'First Name' )); ?>
<?=$this->form->field('lastname', array('label'=>'Last Name','placeholder'=>'Last Name' )); ?>
<?=$this->form->field('username', array('label'=>'Username','placeholder'=>'username' )); ?>

<?=$this->form->field('email', array('label'=>'Email','placeholder'=>'name@youremail.com' )); ?>
<?=$this->form->field('password', array('type' => 'password', 'label'=>'Password','placeholder'=>'Password' )); ?>
<?=$this->form->field('password2', array('type' => 'password', 'label'=>'Password Verification','placeholder'=>'same as above' )); ?>
<?php // echo $this->recaptcha->challenge();?>
<?=$this->form->submit('Sign up' ,array('class'=>'btn btn-primary')); ?>
<?=$this->form->end(); ?>
</div>
</div>
