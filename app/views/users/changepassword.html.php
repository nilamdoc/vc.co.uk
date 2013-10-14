<h4>Change password</h4>
<?=$this->form->create("",array('url'=>'/users/password/')); ?>
<?=$this->form->field('email', array('type' => 'text', 'label'=>'Your email address','placeholder'=>'email@domain.com' )); ?>					
<?=$this->form->field('password', array('type' => 'password', 'label'=>'New Password','placeholder'=>'Password' )); ?>
<?=$this->form->field('password2', array('type' => 'password', 'label'=>'Repeat new password','placeholder'=>'same as above' )); ?>
<?=$this->form->hidden('key', array('value'=>$key))?>
<?=$this->form->submit('Change' ,array('class'=>'btn btn-primary')); ?>					
<?=$this->form->end(); ?>
