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
	<?=$this->form->field('googleauth', array('type' => 'password', 'label'=>'Google Authenticator')); ?>
	<?=$this->form->submit('Login' ,array('class'=>'btn btn-primary')); ?>
	<?=$this->form->end(); ?>
	<a href="/users/forgotpassword">Forgot password?</a>
	</div>
	<div class="span6">
		<div class="navbar">
			<div class="navbar-inner">
			<a class="brand" href="#"><?=$t('Two Factor Authentication')?> </a>
			</div>
		</div>
		We require a Two Factor Authentication for your account to sign in to <?=COMPANY_URL?>.
		We use Time-based One-time Password Algorithm (TOTP).
		<p><h3>Android App</h3>
			<ul>
			<li><a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2" target="_blank">Android App</a></li>
			</ul>
		</p>
		<p><h3>iOS App</h3>
			<ul>
			<li><a href="http://itunes.apple.com/us/app/google-authenticator/id388497605?mt=8" target="_blank">iOS App</a></li>
			</ul>
		</p>
		<p><h3>Google Authenticator Project</h3>
			<ul>
			<li><a href="http://code.google.com/p/google-authenticator/" target="_blank">Google Authenticator</a></li>
			</ul>
		</p>
		
	</div>

</div>