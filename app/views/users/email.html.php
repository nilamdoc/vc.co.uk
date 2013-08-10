<h3>Email Verification:</h3>
<?php echo $msg;?>
<?=$this->form->create("",array('url'=>'/users/confirm/')); ?>
<?=$this->form->field('email', array('label'=>'Email','placeholder'=>'name@youremail.com' )); ?>
<?=$this->form->field('verified', array('type' => 'text', 'label'=>'Verification code','placeholder'=>'50d54d309d5d0c3423000000' )); ?>
<?=$this->form->submit('Verify',array('class'=>'btn btn-primary')); ?>
<?=$this->form->end(); ?>
<p>Please check your spam folder too while checking your inbox!</p>