<?php
use app\models\Parameters;
$Comm = Parameters::find('first');
?>
<div class="row">
	<div class="span4 well">
		<div class="navbar">
			<div class="navbar-inner1">
			<a class="brand" href="#"><?=$t('Signup')?> </a>
			</div>
		</div>
		<?=$this->form->create($user); ?>
		<?php if($refer!=""){?>
		<?=$this->form->field('refer', array('label'=>'Refered by bitcoin address','value'=>$refer,'readonly'=>'readonly','class'=>'span4' )); ?>
		<?php }else{?>
		<?=$this->form->field('refer', array('type'=>'hidden','value'=>'')); ?>
		<?php }?>
		<?=$this->form->field('firstname', array('label'=>'First Name','placeholder'=>'First Name' )); ?>
		<?=$this->form->field('lastname', array('label'=>'Last Name','placeholder'=>'Last Name' )); ?>
		<?=$this->form->field('username', array('label'=>'Username','placeholder'=>'username' )); ?>
		<p class="label label-important">Only characters and numbers, NO SPACES</p>
		<?=$this->form->field('email', array('label'=>'Email','placeholder'=>'name@youremail.com' )); ?>
		<?=$this->form->field('password', array('type' => 'password', 'label'=>'Password','placeholder'=>'Password' )); ?>
		<?=$this->form->field('password2', array('type' => 'password', 'label'=>'Password Verification','placeholder'=>'same as above' )); ?>
		<?php // echo $this->recaptcha->challenge();?>
		<?=$this->form->submit('Sign up' ,array('class'=>'btn btn-primary')); ?>
		<?=$this->form->end(); ?>
	</div>
	<div class="span6 well">
		<div class="navbar">
			<div class="navbar-inner2">
			<a class="brand" href="#"><?=$t('Advantages')?> </a>
			</div><br>
		<h3>In Bitcoin We Trust: ibwt.co.uk</h3>
		<ul>
			<li>Fees are <strong><?=$Comm['value']?></strong>% per transaction.</li>
    	<li>Cold Storage, SSL and 256bit encryption.</li>
    <li>2FA login and coin withdrawal, with optional 3FA login.</li>
    <li>Deposits & Withdrawals immune to banking interference.</li>
    <li>Exchange available to all internationally and nationally.</li>
    <li>Fiat Deposits/Withdrawals currently only for UK residents.</li>
		</ul>

<p>To become an IBWT customer and use our platform and services, you only need the following;
<ul>
    <li>To trade BTC/LTC - registered email.</li>
    <li>To deposit fiat - registered email.</li>
    <li>To withdraw fiat - verified proof of address.</li>
    <li>To deposit/withdraw fiat over &pound;10,000 a day - valid government photo ID.</li>
</ul>
</p>
<p>Please make sure you check - <a href="/files/Withdrawal%20Verification.pdf" target="_blank">7 Easy Verifcation Steps</a> 
<p>For further details on verification, deposits and withdrawals, please check.
<ul>
    <li><a href="/company/verification">Verification</a></li>
    <li><a href="/company/funding">Funding</a></li>
</ul>		
</p>
Any issues please contact us at <a href="mailto:support@ibwt.co.uk">support@ibwt.co.uk</a>
</p>
		</div>
	</div>
</div>
