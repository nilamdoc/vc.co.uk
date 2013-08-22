<div class="well">
<h3>Contact us</h3>
	<?=$this->form->create(null); ?>
	<?=$this->form->field('name', array('label'=>'Name','placeholder'=>'Name')); ?>
	<?=$this->form->field('email', array('label'=>'Email','placeholder'=>'name@youremail.com')); ?>	
	<?=$this->form->field('phone', array('label'=>'Phone','placeholder'=>'phone number')); ?>		
	<?=$this->form->field('mobile', array('label'=>'Mobile','placeholder'=>'mobile number')); ?>			
	<?=$this->form->field('subject', array('label'=>'Subject','placeholder'=>'Subject')); ?>	
	<?=$this->form->textarea('suggest', array('label'=>'Suggest','placeholder'=>'Suggest')); ?>	<br>
	<?=$this->form->submit('Submit' ,array('class'=>'btn btn-primary')); ?>
	<?=$this->form->end(); ?>
</div>