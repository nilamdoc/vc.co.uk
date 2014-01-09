<h4><?=$t("Add/Edit bank - Business")?>:</h4>
<p><?=$t("This will un-set 'verified' status, you will have to verify the bank again.")?></p>
<div class="row-fluid">
	<div class="span4">
<?php
foreach($details as  $d){
?>
<?=$this->form->create('',array('url'=>'/users/addbankBussdetails')); ?>
<?=$this->form->field('accountname', array('label'=>'1. Account name','placeholder'=>'Account name','value'=>$d['bankBuss']['accountname'])); ?>
<?=$this->form->field('sortcode', array('label'=>'2. Sort code','placeholder'=>'Sort code','value'=>$d['bankBuss']['sortcode'] )); ?>
<?=$this->form->field('accountnumber', array('label'=>'3. Account number','placeholder'=>'Account number','value'=>$d['bankBuss']['accountnumber'] )); ?>
<?=$this->form->field('bankname', array('label'=>'4. Bank name','placeholder'=>'Bank name','value'=>$d['bankBuss']['bankname'] )); ?>
<?=$this->form->field('branchaddress', array('label'=>'5. Branch address','placeholder'=>'Branch address','value'=>$d['bankBuss']['branchaddress'] )); ?>
<?=$this->form->submit('Save bank',array('class'=>'btn btn-primary')); ?>
<?=$this->form->end(); ?>
<?php }?>
	</div>
	<div class="span8">
		<p><?=$t("Sample bank cheque for adding bank details.")?></p>
		<img src="/img/Cheque.png" alt="sample bank cheque">	
		<p>At present we only support the following banks: 
<ul>
<li>Natwest</li>
<li>Lloyds</li>
<li>Barclays</li>
<li>TSB</li>
<li>HSBC</li>
<li>Royal Bank of Scotland</li>
<li>Co-Operative Bank</li>
<li>Sandander</li>
<li>Halifax</li>
<li>Handelsbanken</li>
</ul>
</p>
<p>If your bank is not listed, do not worry, please contact us via support@ibwt.co.uk and we will confirm whether or not your bank falls within our locality.</p>
	</div>
</div>
