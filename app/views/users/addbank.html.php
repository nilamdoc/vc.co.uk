<h4>Add/Edit bank:</h4>
<p>This will un-set "verified" status, you will have to verify the bank again. Once verified rBitcoin will be able to transfer the funds to your bank account the same day.</p>
<div class="row-fluid">
	<div class="span4">
<?php
foreach($details as  $d){
?>
<?=$this->form->create('',array('url'=>'/users/addbankdetails')); ?>
<?=$this->form->field('bankname', array('label'=>'1. Bank name','placeholder'=>'Bank Name','value'=>$d['bank']['bankname'])); ?>
<?=$this->form->field('accountnumber', array('label'=>'2. Account number','placeholder'=>'Account number','value'=>$d['bank']['accountnumber'] )); ?>
<?=$this->form->field('branchname', array('label'=>'3. Branch name','placeholder'=>'Branch name','value'=>$d['bank']['branchname'] )); ?>
<?=$this->form->field('micrnumber', array('label'=>'4. MICR number','placeholder'=>'MICR number','value'=>$d['bank']['micrnumber'] )); ?>
<?=$this->form->field('accountname', array('label'=>'5. Account name','placeholder'=>'Account name','value'=>$d['bank']['accountname'] )); ?>
<?=$this->form->submit('Save bank',array('class'=>'btn btn-primary','onclick'=>'return addBank();')); ?>
<?=$this->form->end(); ?>
<?php }?>
	</div>
	<div class="span8">
		<p>Sample bank cheque for adding bank details.		</p>
		<img src="/img/BankCheque.png" alt="sample bank cheque">	
	</div>
</div>
