<div class="well" style="background-image:url(/img/Stamp.png);background-position:bottom right;background-repeat:no-repeat;min-height:600px">
<h4>API Access:</h4>
<?php 
if($StartDate==""){
$StartDate = gmdate('Y-m-d',mktime(0,0,0,gmdate('m',time()),gmdate('d',time()),gmdate('Y',time()))-60*60*24*2);
$EndDate = gmdate('Y-m-d',time()+1*60*60*24);
}else{
$StartDate=gmdate('Y-m-d',$StartDate->sec);
$EndDate=gmdate('Y-m-d',$EndDate->sec);
}
?>
<form action="/Admin/api" method="post">
<div class="input-append date" id="StartDate" data-date="<?=$StartDate?>" data-date-format="yyyy-mm-dd">
	<input class="span2" size="16" name="StartDate" type="text" value="<?=$StartDate?>" readonly>
	<span class="add-on"><i class="icon-calendar"></i></span>
</div>
<div class="input-append date" id="EndDate" data-date="<?=$EndDate?>" data-date-format="yyyy-mm-dd">
	<input class="span2" size="16"  name="EndDate" 	type="text" value="<?=$EndDate?>" readonly>
	<span class="add-on"><i class="icon-calendar"></i></span>
</div>
	<input type="submit" value="Get report" class="btn btn-primary">
<div class="alert alert-error" id="alert"><strong></strong></div>
</form>
<table class="table table-condensed table-bordered table-hover" style="font-size:12px">
	<tr>
		<th colspan="2">Date</th>
	</tr>
	<?php foreach($new as $key=>$val){?>
	<tr>
		<td><?=$key?></td>
		<td>
		<?php foreach($val as $userkey=>$userval){ ?>
			<strong><?php print_r($userkey);?></strong><br>
			<?php foreach($userval as $funckey=>$funcval){ ?>
					<strong> &nbsp;&raquo; <?php print_r($funckey)?></strong>: 
					<?php foreach($funcval as $ipkey=>$ipval){ ?>
					IP: <?php print_r($ipkey)?>, Requests: <?php print_r($ipval['Request'])?><br>
					<?php }?>
			<?php }?>
			<br>
		<?php }?>		
		</td>
	</tr>
	<?php }?>
</table>
</div>
<script src="/js/admin.js"></script>