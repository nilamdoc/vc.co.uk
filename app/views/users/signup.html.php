<div class="row">
	<div class="span4 well">
		<div class="navbar">
			<div class="navbar-inner">
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
		
		<?=$this->form->field('email', array('label'=>'Email','placeholder'=>'name@youremail.com' )); ?>
		<?=$this->form->field('password', array('type' => 'password', 'label'=>'Password','placeholder'=>'Password' )); ?>
		<?=$this->form->field('password2', array('type' => 'password', 'label'=>'Password Verification','placeholder'=>'same as above' )); ?>
		<?php // echo $this->recaptcha->challenge();?>
		<?=$this->form->submit('Sign up' ,array('class'=>'btn btn-primary')); ?>
		<?=$this->form->end(); ?>
	</div>
	<div class="span6 well">
		<div class="navbar">
			<div class="navbar-inner">
			<a class="brand" href="#"><?=$t('Advantages')?> </a>
			</div><br>
		<h3>In Bitcoin We Trust: ibwt.co.uk</h3>
		<ul>
			<li>Fees are 0.8% per transaction</li>
			<li>Simple verification means you could be a full customer in a matter of days</li>
			<li>Security ensured with Cold Storage, SSL 256bit encryption & 2FA</li>
			<li>Dedicated Server for an enhanced customer experience</li>
			<li>Deposits & Withdrawals via wire transfers</li>
			<li>Services only available to UK residents</li>
			<li>Based and registered within the UK to help build your trust</li>
		</ul>
	<p>To become IBWT customer and use our platform and services, you must submit the following information:
		<ul>
			<li>Full name</li>
			<li>Government issued photo identification</li>
			<li>Proof of address (utility bill, credit statement, or official recognised* letter, NOT mobile phone bill)</li>
			<li>Bank details for linked bank account, must be in customers own name (account number, sort code, account name).</li>
			<li>Contact telephone number.</li>
			<li>Contact email.</li>
		</ul>
	</p>	
		</div>
	</div>
</div>
