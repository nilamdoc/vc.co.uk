<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2012, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License

 */
 use lithium\storage\Session;
 use lithium\g11n\Message;
?>
<!doctype html>
<html>
<head>
	<?php echo $this->html->charset();?>
	<title><?php echo MAIN_TITLE;?>: <?php if(isset($title)){echo $title;} ?></title>
	<?php echo $this->html->style(array('/bootstrap/css/bootstrap')); ?>
	<?php echo $this->html->style(array('/bootstrap/css/bootstrap-responsive')); ?>	
	<?php echo $this->html->style(array('/bootstrap/css/docs')); ?>	
	<?php echo $this->html->link('Icon', null, array('type' => 'icon')); ?>
	<?php
	$this->scripts('<script src="/bootstrap/js/jquery.js"></script>'); 
	$this->scripts('<script src="/js/main.js"></script>'); 	
	$this->scripts('<script src="/bootstrap/js/application.js"></script>'); 
	$this->scripts('<script src="/bootstrap/js/bootstrap-affix.js"></script>'); 
	$this->scripts('<script src="/bootstrap/js/bootstrap-alert.js"></script>'); 
	$this->scripts('<script src="/bootstrap/js/bootstrap-button.js"></script>'); 
	$this->scripts('<script src="/bootstrap/js/bootstrap-carousel.js"></script>'); 
	$this->scripts('<script src="/bootstrap/js/bootstrap-collapse.js"></script>'); 
	$this->scripts('<script src="/bootstrap/js/bootstrap-dropdown.js"></script>'); 
	$this->scripts('<script src="/bootstrap/js/bootstrap-modal.js"></script>'); 
	$this->scripts('<script src="/bootstrap/js/bootstrap-tooltip.js"></script>'); 
	$this->scripts('<script src="/bootstrap/js/bootstrap-popover.js"></script>'); 
	$this->scripts('<script src="/bootstrap/js/bootstrap-scrollspy.js"></script>'); 
	$this->scripts('<script src="/bootstrap/js/bootstrap-tab.js"></script>'); 
	$this->scripts('<script src="/bootstrap/js/bootstrap-transition.js"></script>'); 
	$this->scripts('<script src="/bootstrap/js/bootstrap-typeahead.js"></script>'); 
	$this->scripts('<script src="/bootstrap/js/bootstrap.js"></script>'); 
	$this->scripts('<script src="/bootstrap/js/bootstrap.min.js"></script>'); 
	?>   		
    <style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 20px;
      }
      /* Custom container */
      .container {
        margin: 0 auto;
        max-width: 1100px;
      }
      .container > hr {
        margin: 20px 0;
      }
    </style>
</head>
<body onLoad="UpdateDetails();">
	<div id="container" class="container">
		<?php 	echo $this->_render('element', 'header');?>
		<?php 
		extract(lithium\g11n\Message::aliases());
		$user = Session::read('member'); ?>
		<?php	if($user!=""){ ?>
			<?php 	if($controller!='articles'){ ?>
				<?php 	// echo $this->_render('element', 'menu');?>
			<?php } ?>
		<?php }else{?>
		<?php 	// echo $this->_render('element', 'splash');?>		
		<?php }?>
		<?php 	echo $this->_render('element', 'menu');?>		
		<?php echo $this->content(); ?>
	</div>
	<?php 	echo $this->_render('element', 'footer');?>	
<?php echo $this->scripts(); ?>	
<script >
$(function() {
	$('.tooltip-x').tooltip();
});
</script>

</body>
</html>