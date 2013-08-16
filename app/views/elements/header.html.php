<?php
use lithium\storage\Session;
use app\extensions\action\Functions;
?>
<?php $user = Session::read('member'); ?>
<div class="navbar navbar-fixed-top" >
	<div class="navbar-inner" style="width: auto; padding: 0 20px;">
		<div class="container"  style="width: 90%; padding: 0 20px;" >
			<!-- .btn-navbar is used as the toggle for collapsed navbar content -->
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			</a>
			<!-- Be sure to leave the brand out there if you want it shown -->
			<a class="brand" href="/"><img src="/img/ibwt.co.uk.gif" alt="ibwt.co.uk"></a>
			<!-- Everything you want hidden at 940px or less, place within here -->
		<div>

			<!-- .nav, .navbar-search, .navbar-form, etc -->
				<div class="nav-collapse collapse">
				<ul class="nav">
					<li><a class=" tooltip-x" rel="tooltip-x" data-placement="bottom" title="Latest low price" href="#"><?=$t('Low')?>:<strong><span id="LowPrice" class="btn-success" style="padding:2px"></span></strong></a></li>
					<li><a class=" tooltip-x" rel="tooltip-x" data-placement="bottom" title="Latest high price" href="#"><?=$t('High')?>:<strong><span id="HighPrice" class="btn-danger"  style="padding:2px"></span></strong></a></li>
					<li><a class=" tooltip-x" rel="tooltip-x" data-placement="bottom" title="Latest price" href="#"><?=$t('Last')?>:<strong><span id="LastPrice" class="btn-info"  style="padding:2px"></span></strong></a></li>					
					<li><a class=" tooltip-x" rel="tooltip-x" data-placement="bottom" title="Volume" href="#"><?=$t('Volume')?>:<strong><span id="Volume" class="btn-inverse"  style="padding:2px"></span></strong></a></li>										
			<?php if($user!=""){ ?>
<!--					<li ><a href="/dashboard"><strong class="label label-success"><?=$t('Finances')?></strong></a></li>					
-->
			<?php }?>
				</ul>
				</div>
			</div>
			<ul class="nav pull-right">
				<?php echo $this->_render('element', 'language');?>
			<?php if($user!=""){ ?>
			<li ><a href='#' class='dropdown-toggle' data-toggle='dropdown' style="background-color:#eeeeee ">
			<?=$user['username']?> <i class=' icon-chevron-down'></i>
			</a>
			<ul class="dropdown-menu">
				<li><a href="/users/settings"><?=$t('Settings')?></a></li>			
				<li><a href="/dashboard"><?=$t('Dashboard')?></a></li>
				<li class="divider"></li>
				<li><a href="/logout"><?=$t('Logout')?></a></li>
			</ul>
			<?php }else{?>
					<a href="/login" class="btn"><?=$t('Login')?></a>			
			<?php }?>				
			</ul>			

		</div>
	</div>
</div>
	<img src="/img/half-ibwt.co.uk.png" class="pull-right" style="margin-top:7px">