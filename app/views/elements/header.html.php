<?php
use lithium\storage\Session;
use app\extensions\action\Functions;
?>
<?php use lithium\core\Environment; 
if(substr(Environment::get('locale'),0,2)=="en"){$locale = "en";}else{$locale = Environment::get('locale');}
//if(strlen($locale>2)){$locale='en';}
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
			<a class="brand" href="/<?=$locale?>/"><img src="/img/ibwt.co.uk.gif" alt="In Bitcoin We Trust" title="In Bitcoin We Trust"></a>
			<!-- Everything you want hidden at 940px or less, place within here -->
		<div>

			<!-- .nav, .navbar-search, .navbar-form, etc -->
				<div class="nav-collapse collapse">
				<?php if($this->_request->controller=='ex'){ ?>
				<ul class="nav" style="font-size:12px ">
					<li><a class=" tooltip-x" rel="tooltip-x" data-placement="bottom" title="Latest low price" href="#"><?=$t('Low')?>:<strong><span id="LowPrice" class="btn-success" style="padding:2px"></span></strong></a></li>
					<li><a class=" tooltip-x" rel="tooltip-x" data-placement="bottom" title="Latest high price" href="#"><?=$t('High')?>:<strong><span id="HighPrice" class="btn-danger"  style="padding:2px"></span></strong></a></li>
					<li><a class=" tooltip-x" rel="tooltip-x" data-placement="bottom" title="Latest price" href="#"><?=$t('Last')?>:<strong><span id="LastPrice" class="btn-info"  style="padding:2px"></span></strong></a></li>					
					<li><a class=" tooltip-x" rel="tooltip-x" data-placement="bottom" title="Volume" href="#"><?=$t('Vol')?>:<strong><span id="Volume" class="btn-inverse"  style="padding:2px"></span></strong></a></li>										
			<?php if($user!=""){ ?>
<!--					<li ><a href="/dashboard"><strong class="label label-success"><?=$t('Finances')?></strong></a></li>					
-->
			<?php }?>
				</ul>
				<?php }else{?>
				<ul class="nav">				
					<li><a  style="font-size:30px;color:#333;font-weight:bold;" >Virtual Currency Exchange</a></li>
				</ul>
				<?php }?>				
				</div>
			</div>
			<ul class="nav pull-right">
				<?php //echo $this->_render('element', 'language');?>
			<?php if($user!=""){ ?>
			<li ><a href='#' class='dropdown-toggle' data-toggle='dropdown' style="background-color:#eeeeee ">
			<?=$user['username']?> <i class=' icon-chevron-down'></i>
			</a>
			<ul class="dropdown-menu">
				<li><a href="/<?=$locale?>/users/settings"><?=$t('Settings')?></a></li>			
				<li><a href="/<?=$locale?>/ex/dashboard"><?=$t('Dashboard')?></a></li>
				<li class="divider"></li>				
				<li><a href="/<?=$locale?>/users/funding_btc"><?=$t('Funding BTC')?></a></li>							
				<li><a href="/<?=$locale?>/users/funding_ltc"><?=$t('Funding LTC')?></a></li>											
				<li><a href="/<?=$locale?>/users/funding_xgc"><?=$t('Funding XGC')?></a></li>															
				<li><a href="/<?=$locale?>/users/funding_fiat"><?=$t('Funding Fiat')?></a></li>											
				<li class="divider"></li>								
				<li><a href="/<?=$locale?>/users/transactions"><?=$t('Transactions')?></a></li>							
				<li class="divider"></li>
				<li><a href="/<?=$locale?>/print/"><?=$t('Print / Cold Storage')?></a></li>											
				<li class="divider"></li>												
				<li><a href="/<?=$locale?>/logout"><?=$t('Logout')?></a></li>
			</ul>
			<?php }else{?>
					<a href="/<?=$locale?>/login" class="btn"><?=$t('Login / Register')?></a>			
			<?php }?>				
			</ul>			
		</div>
	</div>
</div>
<?php 
if(str_replace("@","",strstr($user['email'],"@"))==COMPANY_URL 
	&& $details['email.verified']=="Yes"
	&& $details['TOTP.Validate'] == 1
	&& $details['TOTP.Login'] == 1
	&& ( 
	   MAIL_1==$user['email'] 
	|| MAIL_2==$user['email'] 
	|| MAIL_3==$user['email'] 	
	|| MAIL_4==$user['email'] 	
	   )
){
?>
<a href="/Admin">
<?php }?>
<img src="/img/half-ibwt.co.uk.png" class="pull-right" style="margin-top:7px">
<?php 

if(str_replace("@","",strstr($user['email'],"@"))==COMPANY_URL 
	&& $details['email.verified']=="Yes"
	&& $details['TOTP.Validate'] == 1
	&& $details['TOTP.Login'] == 1
	&& ( 
	   MAIL_1==$user['email'] 
	|| MAIL_2==$user['email'] 
	|| MAIL_3==$user['email'] 	
	|| MAIL_4==$user['email'] 	
	   )
){
?>
</a>
<?php }?>