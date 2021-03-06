<div style="background-image:url(/img/Stamp.png);background-position:bottom right;background-repeat:no-repeat">

<p class="alert alert-error" style="font-size:16px;font-weight:bold;text-align:center ">
IBWT has teamed up with <a href="https://okpay.com/" target="_blank">OKPAY</a> to allow international access to its platform, please see our latest <a href="/files/News Release 30-01-14.pdf" title="News Release">News Release</a> for more details...</p>

<div class="row container">
	<div class="span4 well" >
		<div class="navbar">
			<div class="navbar-inner1">
			<a class="brand" href="#"><?=$t('Login')?> </a>
			</div>
		</div>
		<?=$this->form->create(null); ?>
		<?=$this->form->field('username', array('label'=>'Username', 'onBlur'=>'SendPassword();', 'placeholder'=>'username')); ?>
		<?=$this->form->field('password', array('type' => 'password', 'label'=>'Password', 'placeholder'=>'password')); ?>
		<div class="alert alert-danger"  style="display:none" id="LoginEmailPassword">
		<small>Please check your registered email in 5 seconds. You will receive <br>"<strong>Login Email Password</strong>" use it in the box below.</small>
		<?=$this->form->field('loginpassword', array('type' => 'password', 'label'=>'','class'=>'span1','maxlength'=>'6', 'placeholder'=>'123456')); ?>
		</div>		
		<div style="display:none" id="TOTPPassword" class="alert alert-danger">
		<small><strong>Time based One Time Password (TOTP) from your smartphone</strong></small>	
		<?=$this->form->field('totp', array('type' => 'password', 'label'=>'','class'=>'span1','maxlength'=>'6', 'placeholder'=>'123456')); ?>	
		</div>	
		<?=$this->form->submit('Login' ,array('class'=>'btn btn-primary','id'=>'LoginButton','disabled'=>'disabled')); ?>
		
		
		<?=$this->form->end(); ?>
	<a href="/users/forgotpassword">Forgot password?</a>
	</div>
	<div class="span6 well">
		<div class="navbar">
			<div class="navbar-inner2">
			<a class="brand" href="#"><?=$t('Sign up / Register')?> </a>
			</div>
		</div>
		<h3>Sign up</h3>
		Don't have an account. <a href="/users/signup" class="btn btn-primary">Signup</a><br>
		Please read the <a href="/company/termsofservice">terms of service</a> page before you sign up.<br>
		<h3>Security</h3>
		We use <strong>Two Factor Authentication</strong> for your account to login to <?=COMPANY_URL?>.<br>
		We use <strong>Time-based One-time Password Algorithm (TOTP)</strong> for login, withdrawal/deposits and settings.
		<p><h3>TOTP Project and downloads</h3>
			<ul>
			<li><a href="http://code.google.com/p/google-authenticator/" target="_blank">Google Authenticator</a></li>
			<li><a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2" target="_blank">TOTP Android App</a></li>
			<li><a href="http://itunes.apple.com/us/app/google-authenticator/id388497605?mt=8" target="_blank">TOTP iOS App</a></li>
			</ul>
		</p>
	</div>
</div><br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>

</div>
