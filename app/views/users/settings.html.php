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
	<div id="collapsePersonal" class="accordion-body <?php if($option=="personal"){?><?php }else{?>collapse<?php }?>">
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
					if($details['mobile']['verified']=='' || $details['mobile']['verified']=='No'){
						echo "<a href='/users/mobile/".$details['mobile']['number']."'  class='label label-important'>Verify</a>";
						}else{
						echo $details['mobile.number'];
					}?></td>
			</tr>
			<?php }?>
			<tr>
				<td>Bitcoin Adresses: <br>
				<td>
				<?php 
					$qrcode = new QRcode();
				foreach($details['bitcoinaddress'] as $a){
					$qrcode->png($a, QR_OUTPUT_DIR.$a.'.png', 'H', 7, 2);
					echo $a;
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
	<div id="collapseBank" class="accordion-body <?php if($option=="bank"){?><?php }else{?>collapse<?php }?>">
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
	<div class="accordion-heading" style="background-color:#c0d1b0">
		<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseGovernment">
		<strong class="label label-success">Government ID:</strong>
		</a>
	</div>
	<div id="collapseGovernment" class="accordion-body <?php if($option=="government"){?><?php }else{?>collapse<?php }?>">
		<div class="accordion-inner">
						<?php if(strlen($details['government.verified'])==0){?>
						<?=$this->form->create(null, array('type' => 'file')); ?>
						<?=$this->form->field('file', array('type' => 'file','label'=>'Upload a JPG')); ?><br>
						<?=$this->form->field('option',array('type'=>'hidden','value'=>'government')); ?>												
						<?=$this->form->submit('Save',array('class'=>'btn btn-primary')); ?>
						<?=$this->form->end(); ?>
						<?php }else{?>
							<?php if($details['government.verified']=="No"){?>
							<p class="label label-warning">Waiting for approval</p>
							<?php	}else{?>
							<p class="label label-success">Approved</p>
							<?php }?>
						<?php	if($imagename_government!=""){?>
							<img src="/documents/<?=$imagename_government?>" width="300px" style="padding:1px;border:1px solid black ">					
							<?php }?>
						<?php }?>						
		</div>
	</div>		
	<div class="accordion-heading" style="background-color:#c0d1b0">
		<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseUtility">
		<strong class="label label-success">Utility Bill:</strong>
		</a>
	</div>
	<div id="collapseUtility" class="accordion-body <?php if($option=="utility"){?><?php }else{?>collapse<?php }?>">
		<div class="accordion-inner">
						<?php if(strlen($details['utility.verified'])==0){?>
						<?=$this->form->create(null, array('type' => 'file')); ?>
						<?=$this->form->field('file', array('type' => 'file','label'=>'Upload a JPG')); ?><br>
						<?=$this->form->field('option',array('type'=>'hidden','value'=>'utility')); ?>						
						<?=$this->form->submit('Save',array('class'=>'btn btn-primary')); ?>
						<?=$this->form->end(); ?>
						<?php }else{?>						
							<?php if($details['utility.verified']=="No"){?>
							<p class="label label-warning">Waiting for approval</p>
							<?php	}else{?>
							<p class="label label-success">Approved</p>
							<?php }?>
						<?php }?>							
						<?php if($imagename_utility!=""){?>
						<img src="/documents/<?=$imagename_utility?>" width="300px" style="padding:1px;border:1px solid black ">					
						<?php }?>
		</div>
	</div>		
	<div class="accordion-heading" style="background-color:#b0c1a0 ">
		<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseAPI">
		<strong class="label label-success">Security:</strong>
		</a>
	</div>
	<div id="collapseAPI" class="accordion-body  <?php if($option=="security"){?><?php }else{?>collapse<?php }?>">
		<div class="accordion-inner">
		<?php 
		if($details['TOTP.Security']==false || $details['TOTP.Security']==""){?>
		<table class="table">
			<tr>
				<td colspan="2">
					Security keys are used for withdrawals and deposits to your account with <?=COMPANY_URL?>. <br>
					Download / Install the app from <a href="http://code.google.com/p/google-authenticator/" target="_blank">Google Authenticator</a><br>
					Scan the QR code and enter a (Time based One Time Password) to enable security on withdrawals / deposits and password recovery.
					<div class="alert">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Best practice</strong> is to select all Login, Withdrawals/Deposits and Security for TOTP.
					</div>
				</td>
			</tr>
			<tr>
				<td>

		<div class="control-group">
			<div class="controls">
					<strong>Use TOTP for</strong>:<br>
				<label class="checkbox">
				<input type="checkbox" name="Login" id="Login" checked=true> Login
				</label>
				<label class="checkbox">
				<input type="checkbox" name="Withdrawal" id="Withdrawal" checked=true> Withdrawal / Deposits
				</label>
				<label class="checkbox">
				<input type="checkbox" name="Security" id="Security" checked=true> Security
				</label>
			</div>				
		</div>	
		<div class="control-group">
			<label class="control-label" for="ScannedCode">Scanned code</label>
			<div class="controls">
				<input type="text" id="ScannedCode" name="ScannedCode" placeholder="123456" class="span1"  maxlength="6">
			</div><br>
			<div class="controls">			
				<button type="button" class="btn btn-primary" onClick="return SaveTOTP();">Save</button>										
				<button type="button" class="btn btn-danger"  onClick="return DeleteTOTP();">Delete</button>														
			</div>
		</div>

				</td>
				<td>
					<iframe frameborder="0" src="<?=$qrCodeUrl?>" scrolling="no" height="200px"></iframe>
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
		<?php }else{?>
		<table class="table">
			<tr>
				<td colspan="2">
					You have enabled TOTP Security for <?=COMPANY_URL?>. <br>
					Please enter the code below to modify the security level.
					
					<div class="alert">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Warning! </strong> Once you click on the "Check" button with the correct code, you will have to delete your current TOTP from your mobile and rescan the code on the next page.
					</div>
					
				</td>
			</tr>
			<tr>
				<td colspan="2">
				You have enabled:<br>
				Validate: <strong><?=$details['TOTP.Validate']?></strong><br>
				Login: <strong><?=$details['TOTP.Login']?></strong><br>
				Withdrawal / Deposit: <strong><?=$details['TOTP.Withdrawal']?></strong><br>				
				Security: <strong><?=$details['TOTP.Security']?></strong><br>				
				</td>
			</tr>
			<tr>
				<td>
				<?=$this->form->create(null, array('class'=>'form-horizontal')); ?>
				<div class="control-group">
					<label class="control-label" for="CheckCode">Scanned code</label>
					<div class="controls">
						<input type="text" id="CheckCode" name="CheckCode" placeholder="123456" class="span1" maxlength="6">
					</div><br>
					<div class="controls">			
						<button type="button" class="btn btn-primary" onClick="CheckTOTP();">Check</button>										
					</div>
				</div>

				<?=$this->form->end(); ?>
				</td>
		</table>
		<?php	}?>
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
