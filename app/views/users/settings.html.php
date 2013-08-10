<h4>Add private key</h4>
<?=$this->form->create('',array('url'=>'/users/addprivatekey')); ?>
<?=$this->form->field('username', array('label'=>'User name','placeholder'=>'Username','value'=>$username)); ?>
<?=$this->form->field('privatekey', array('label'=>'Private key','placeholder'=>'privatekey','value'=>'','class'=>'span5')); ?>
<?=$this->form->submit('Generate Vanity Address',array('class'=>'btn btn-primary')); ?>
<?=$this->form->end(); ?>
