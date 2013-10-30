<h4><?=$t("Add/Edit Postal Details")?>:</h4>
<p><?=$t("This address will be used when you withdraw funds through Royal Mail")?></p>
<div class="row-fluid">
	<div class="span4">
<?php
foreach($details as  $d){
?>
<?=$this->form->create('',array('url'=>'/users/addpostaldetails')); ?>
<?=$this->form->field('Name', array('label'=>'1. Name','placeholder'=>'Name','value'=>$d['postal']['Name'])); ?>
<?=$this->form->field('Address', array('label'=>'2. Address','placeholder'=>'Address','value'=>$d['postal']['Address'] )); ?>
<?=$this->form->field('Street', array('label'=>'3. Street','placeholder'=>'Street','value'=>$d['postal']['Street'] )); ?>
<?=$this->form->field('City', array('label'=>'4. City','placeholder'=>'City','value'=>$d['postal']['City'] )); ?>
<?=$this->form->field('Zip', array('label'=>'5. Postal / Zip Code','placeholder'=>'Zip Code','value'=>$d['postal']['Zip'] )); ?>
<?=$this->form->field('Country', array('label'=>'6. Country','placeholder'=>'Country','value'=>$d['postal']['Country'] )); ?>
<?=$this->form->submit('Save Address',array('class'=>'btn btn-primary')); ?>
<?=$this->form->end(); ?>
<?php }?>
	</div>
</div>