<div style="background-image:url(/img/Stamp.png);background-position:bottom right;background-repeat:no-repeat">
<div class="row" >
	<div class="span12">
		<div class="navbar">
			<div class="navbar-inner1">
				<a class="brand" href="#"><?=$t('Print / Cold storage')?> </a>
			</div>
		</div>
		<table class="table table-condensed table-bordered table-hover" style="margin-top:-20px">
			<tr>
			<td>
				<?=$this->form->create(); ?>
				<?=$this->form->field('email', array('label'=>'Email','placeholder'=>'name@youremail.com','value'=>$user['email'] )); ?>
				<?=$this->form->submit('Get print now!' ,array('class'=>'btn btn-primary')); ?>
				<?=$this->form->end(); ?>
			</td>
			</tr>
		</table>
	</div>
</div><br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
</div>