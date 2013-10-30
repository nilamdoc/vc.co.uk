<h4><?=$t("Add/Edit bank")?>:</h4>
<p><?=$t("This will un-set 'verified' status, you will have to verify the bank again.")?></p>
<div class="row-fluid">
	<div class="span4">
<?php
foreach($details as  $d){
?>
<?=$this->form->create('',array('url'=>'/users/addbankdetails')); ?>
<?=$this->form->field('accountname', array('label'=>'1. Account name','placeholder'=>'Account name','value'=>$d['bank']['accountname'])); ?>
<?=$this->form->field('sortcode', array('label'=>'2. Sort code','placeholder'=>'Sort code','value'=>$d['bank']['sortcode'] )); ?>
<?=$this->form->field('accountnumber', array('label'=>'3. Account number','placeholder'=>'Account number','value'=>$d['bank']['accountnumber'] )); ?>
<?=$this->form->field('bankname', array('label'=>'4. Bank name','placeholder'=>'Bank name','value'=>$d['bank']['bankname'] )); ?>
<?=$this->form->field('branchaddress', array('label'=>'5. Branch address','placeholder'=>'Branch address','value'=>$d['bank']['branchaddress'] )); ?>
<?=$this->form->submit('Save bank',array('class'=>'btn btn-primary')); ?>
<?=$this->form->end(); ?>
<?php }?>
	</div>
	<div class="span8">
		<p><?=$t("Sample bank cheque for adding bank details.")?></p>
		<img src="/img/Cheque.png" alt="sample bank cheque">	
	</div>
</div>
