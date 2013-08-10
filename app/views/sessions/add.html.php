<h2>Login</h2>
<?=$this->form->create(null); ?>
<?=$this->form->field('username', array('label'=>'Username')); ?>
<?=$this->form->field('password', array('type' => 'password', 'label'=>'Password')); ?>
<?=$this->form->submit('Login' ,array('class'=>'btn btn-primary')); ?>
<?=$this->form->end(); ?>
<a href="/users/forgotpassword">Forgot password?</a>
