<?php
use li3_qrcode\extensions\action\QRcode;
?>
<h4>Settings</h4>
<div class="accordion-group" style="background-color:#FFFFFF ">
	<div class="accordion-heading" style="background-color:#D5E2C5 ">
		<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapsePersonal">
		<strong class="label label-success">Personal details:</strong>
		</a>
	</div>
	<div id="collapsePersonal" class="accordion-body collapse">
		<div class="accordion-inner">
		<p>Your personal details are used for signing in to <?=COMPANY_URL?> and accessing your account. </p>
		<table class="table">
			<tr>
				<td>Name:</td>
				<td><?=$user['firstname']?> <?=$user['lastname']?></td>
			</tr>
			<tr>
				<td>Username:</td>
				<td><?=$user['username']?></td>
			</tr>
			<tr>
				<td>Email:</td>
				<td><?=$user['email']?> <?php 
					if($details['email']['verified']=='Yes'){
						echo '<a href="#" class="label label-success">Verified</a>';
						}else{
						echo '<a href="/users/email"  class="label label-important">Verify</a>';
						}?></td>
			</tr>
			<tr>
				<td>Password change:</td>
				<td>
					<?=$this->form->create("",array('url'=>'/users/password/')); ?>
					<?=$this->form->field('oldpassword', array('type' => 'password', 'label'=>'Old Password','placeholder'=>'Password' )); ?>					
					<?=$this->form->field('password', array('type' => 'password', 'label'=>'New Password','placeholder'=>'Password' )); ?>
					<?=$this->form->field('password2', array('type' => 'password', 'label'=>'Repeat new password','placeholder'=>'same as above' )); ?>
					<?=$this->form->hidden('key', array('value'=>$details['key']))?>
					<?=$this->form->submit('Change' ,array('class'=>'btn btn-primary')); ?>					
					<?=$this->form->end(); ?>
				</td>
			</tr>
			<?php
				if($details['email']['verified']=='Yes'){
			?>
			<tr>
				<td>Mobile:</td>
				<td><?php 
					if($details['mobile']['verified']==''){
						echo "<a href='/users/mobile/".$details['mobile']['number']."'  class='label label-important'>Verify</a>";
						}else{
						echo $details['mobile'];
					}?></td>
			</tr>
			<?php }?>
			<tr>
				<td>Bitcoin Adresses: <br>
				<a href="/users/vanity" class='label label-important'>Add vanity address</a></td>
				<td>
				<?php 
					$qrcode = new QRcode();
				foreach($details['bitcoinaddress'] as $a){
					$qrcode->png($a, QR_OUTPUT_DIR.$a.'.png', 'H', 7, 2);
					echo $a;
					echo " <a href='/ShortUrl/get/' class='label'>Get short URL</a><br>";
					echo " <img src='".QR_OUTPUT_RELATIVE_DIR.$a.".png'>";
				}
				?>
				</td>
			</tr>
		</table>
		</div>
	</div>
	<div class="accordion-heading" style="background-color:#c0d1b0">
		<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseBank">
		<strong class="label label-success">Financial details:</strong>
		</a>
	</div>
	<div id="collapseBank" class="accordion-body collapse">
		<div class="accordion-inner">
		<a href="/users/addbank">Add/Edit bank details</a>
		<table class="table">
			<tr>
				<td>Bank Name:</td>
				<td><?=$details['bank']['bankname']?></td>
			</tr>
			<tr>
				<td>Account Number:</td>
				<td><?=$details['bank']['accountnumber']?></td>
			</tr>
			<tr>
				<td>Branch Name:</td>
				<td><?=$details['bank']['branchname']?></td>
			</tr>
			<tr>
				<td>MICR Number:</td>
				<td><?=$details['bank']['micrnumber']?></td>
			</tr>
			<tr>
				<td>Account Name:</td>
				<td><?=$details['bank']['accountname']?></td>
			</tr>
			<tr>
				<td>Verified:</td>
				<td><?=$details['bank']['verified']?>
				<?php 
					if($details['bank']['verified']=='Yes'){
						echo '<a href="#" class="label label-success">Verified</a>';
						}else{
						echo '<a href="/users/verifybank"  class="label label-important">Verify</a>';
						}?>
				</td>
			</tr>
		</table>
		</div>
	</div>
	<div class="accordion-heading" style="background-color:#b0c1a0 ">
		<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseAPI">
		<strong class="label label-success">Security:</strong>
		</a>
	</div>
	<div id="collapseAPI" class="accordion-body ">
		<div class="accordion-inner">
		<table class="table">
			<tr>
				<td colspan="2">
					Security keys are used for withdrawals and deposits to your account with <?=COMPANY_URL?>. 
					Scan the QR code and enter a (Time based One Time Password) to enable 
				</td>
			</tr>
			<tr>
				<td>API Key:</td>
				<td><?=$details['key']?></td>
			</tr>
			<tr>
				<td>API Secret:</td>
				<td><?=$details['secret']?></td>
			</tr>
		</table>
		</div>
	</div>

	<div class="accordion-heading" style="background-color:#F7CCBF ">
		<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseDelete">
		<strong class="label label-important">Delete Account</strong>
		</a>
	</div>
	<div id="collapseDelete" class="accordion-body collapse">
		<div class="accordion-inner">
		<h5>Delete account?</h5>		
		<h6>Why do I need to delete an account?</h6>
		<p>Delete account is used to recover your password. As rbitco.in does not help in changing the password for your account. We can delete the old account and  reset it with a new password only by deleting the account and again sign up for a new account with the same <strong>username</strong>.</p>
		<p>Steps to reset a new password:</p>		
		<ol>
			<li>Delete this account</li>
			<li>Create a new account by signing up</li>
			<li>Use the same <strong>username</strong> </li>
		</ol>
		<?=$this->form->create('',array('url'=>'/users/deleteaccount')); ?>
		<?=$this->form->field('username', array('label'=>'Username','placeholder'=>'username')); ?>
		<?=$this->form->field('email', array('label'=>'Email','placeholder'=>'email')); ?>
		<?=$this->form->submit('Delete Account',array('class'=>'btn btn-danger','onclick'=>'return DeleteAccount();')); ?>
		<?=$this->form->end(); ?>
	</div>
	</div>

</div>
