<div class="well">
<h4>Forgot password</h4>
<?=$this->form->create("",array('url'=>'/users/forgotpassword')); ?>
<?=$this->form->field('email', array('type' => 'text', 'label'=>'Your email','placeholder'=>'name@yourdomain.com' )); ?>					
<?=$this->form->submit('Send password reset link' ,array('class'=>'btn btn-primary')); ?>					
<?=$this->form->end(); ?>
</div>