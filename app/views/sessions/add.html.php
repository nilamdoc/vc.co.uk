<div class="row">
	<div class="span4 well" >
		<div class="navbar">
			<div class="navbar-inner">
			<a class="brand" href="#"><?=$t('Login')?> </a>
			</div>
		</div>
	<?=$this->form->create(null); ?>
	<?=$this->form->field('username', array('label'=>'Username')); ?>
	<?=$this->form->field('password', array('type' => 'password', 'label'=>'Password')); ?>
	<?=$this->form->submit('Login' ,array('class'=>'btn btn-primary')); ?>
	<?=$this->form->end(); ?>
	<a href="/users/forgotpassword">Forgot password?</a>
	</div>
	<div class="span6">
		<div class="navbar">
			<div class="navbar-inner">
			<a class="brand" href="#"><?=$t('Signup')?> </a>
			</div>
		</div>
		You need to signup to trade on the site. Please click to signin.
	</div>

</div>